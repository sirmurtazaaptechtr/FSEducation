<?php

namespace App\Services;

use Illuminate\Http\Request;

class UtmTrackingService
{
    protected const SESSION_KEY = 'marketing_utm_data';

    /**
     * Capture UTM parameters and HTTP referrer from incoming request into session.
     */
    public function capture(Request $request): void
    {
        $hasUtm = $request->hasAny(['utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term']);

        // Capture UTMs if present
        if ($hasUtm) {
            $data = [
                'utm_source' => $request->query('utm_source'),
                'utm_medium' => $request->query('utm_medium'),
                'utm_campaign' => $request->query('utm_campaign'),
                'utm_content' => $request->query('utm_content'),
                'utm_term' => $request->query('utm_term'),
                'captured_at' => now()->toIso8601String(),
            ];

            // Capture referrer if available
            $referrer = $request->header('referer');
            if ($referrer && ! str_contains($referrer, $request->getHost())) {
                $data['referrer_url'] = $referrer;
            }

            $request->session()->put(self::SESSION_KEY, $data);
        } elseif (! $request->session()->has(self::SESSION_KEY)) {
            // First time visit without UTMs: capture external referrer if present
            $referrer = $request->header('referer');
            if ($referrer && ! str_contains($referrer, $request->getHost())) {
                $request->session()->put(self::SESSION_KEY, [
                    'utm_source' => parse_url($referrer, PHP_URL_HOST) ?? 'referral',
                    'utm_medium' => 'referral',
                    'utm_campaign' => null,
                    'utm_content' => null,
                    'referrer_url' => $referrer,
                    'captured_at' => now()->toIso8601String(),
                ]);
            }
        }
    }

    /**
     * Retrieve stored UTM tracking data for inquiry attribution.
     */
    public function getTrackedData(Request $request): array
    {
        $sessionData = $request->session()->get(self::SESSION_KEY, []);

        return [
            'utm_source' => $request->input('utm_source', $sessionData['utm_source'] ?? null),
            'utm_medium' => $request->input('utm_medium', $sessionData['utm_medium'] ?? null),
            'utm_campaign' => $request->input('utm_campaign', $sessionData['utm_campaign'] ?? null),
            'utm_content' => $request->input('utm_content', $sessionData['utm_content'] ?? null),
            'referrer_url' => $sessionData['referrer_url'] ?? $request->header('referer'),
            'ip' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 500),
        ];
    }
}

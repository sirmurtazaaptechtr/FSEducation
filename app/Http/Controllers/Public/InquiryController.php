<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\Public\InquiryFormRequest;
use App\Models\Inquiry;
use App\Services\UtmTrackingService;
use Illuminate\Http\RedirectResponse;

class InquiryController extends Controller
{
    /**
     * Store a prospective student inquiry with marketing attribution (UTM / Referrer).
     */
    public function submit(InquiryFormRequest $request, UtmTrackingService $utmService): RedirectResponse
    {
        $validated = $request->validated();
        $trackingData = $utmService->getTrackedData($request);

        Inquiry::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? null,
            'course_id' => $validated['course_id'] ?? null,
            'centre_id' => $validated['centre_id'] ?? null,
            'mou_partner_id' => $validated['mou_partner_id'] ?? null,
            'referral_code_entered' => $validated['referral_code_entered'] ?? null,
            'message' => $validated['message'] ?? null,
            'status' => 'new',
            'utm_source' => $trackingData['utm_source'] ?? null,
            'utm_medium' => $trackingData['utm_medium'] ?? null,
            'utm_campaign' => $trackingData['utm_campaign'] ?? null,
            'utm_content' => $trackingData['utm_content'] ?? null,
            'referrer_url' => $trackingData['referrer_url'] ?? null,
            'ip' => $trackingData['ip'] ?? null,
            'user_agent' => $trackingData['user_agent'] ?? null,
        ]);

        return back()->with('success', 'Thank you! Your inquiry has been submitted. Our admissions advisor will contact you shortly.');
    }
}

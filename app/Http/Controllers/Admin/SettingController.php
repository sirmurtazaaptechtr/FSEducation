<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingRequest;
use App\Models\Setting;
use App\Services\ImageUploadService;
use App\Services\SettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function index(SettingsService $settingsService): View
    {
        $groupedSettings = $settingsService->getAllByGroup();

        return view('admin.settings.index', compact('groupedSettings'));
    }

    public function update(
        SettingRequest $request,
        SettingsService $settingsService,
        ImageUploadService $imageService
    ): RedirectResponse {
        $validated = $request->validated();

        // Image file uploads
        $imageFields = [
            'site_logo' => ['maxWidth' => 500, 'maxHeight' => 200, 'quality' => 90],
            'site_favicon' => ['maxWidth' => 64, 'maxHeight' => 64, 'quality' => 90],
            'aptech_logo' => ['maxWidth' => 400, 'maxHeight' => 150, 'quality' => 90],
            'arena_logo' => ['maxWidth' => 400, 'maxHeight' => 150, 'quality' => 90],
            'default_og_image' => ['maxWidth' => 1200, 'maxHeight' => 630, 'quality' => 85],
        ];

        foreach ($imageFields as $field => $dims) {
            if ($request->hasFile($field)) {
                $oldPath = setting($field);
                $newPath = $imageService->upload(
                    file: $request->file($field),
                    folder: 'settings',
                    oldPath: $oldPath,
                    maxWidth: $dims['maxWidth'],
                    maxHeight: $dims['maxHeight'],
                    quality: $dims['quality'],
                    generateThumbnail: false
                );
                $validated[$field] = $newPath;
            } else {
                unset($validated[$field]);
            }
        }

        // Toggles / Checkboxes defaulting
        if (! $request->has('show_cookie_notice')) {
            $validated['show_cookie_notice'] = '0';
        }
        if (! $request->has('show_registration_references')) {
            $validated['show_registration_references'] = '0';
        }
        if (! $request->has('show_exact_mou_discounts')) {
            $validated['show_exact_mou_discounts'] = '0';
        }

        // Update settings in database
        foreach ($validated as $key => $value) {
            $existing = Setting::where('key', $key)->first();
            $group = $existing ? $existing->group : 'General';

            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'group' => $group]
            );
        }

        // Invalidate settings cache
        $settingsService->clearCache();

        return redirect()->route('admin.settings.index')
            ->with('success', 'Site settings updated successfully. Changes are now live.');
    }
}


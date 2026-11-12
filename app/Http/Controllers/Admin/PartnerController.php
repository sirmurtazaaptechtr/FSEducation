<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PartnerRequest;
use App\Models\Partner;
use App\Services\ImageUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PartnerController extends Controller
{
    public function index(): View
    {
        $partners = Partner::orderBy('sort_order', 'asc')->get();

        return view('admin.partners.index', compact('partners'));
    }

    public function create(): View
    {
        return view('admin.partners.create');
    }

    public function store(PartnerRequest $request, ImageUploadService $imageService): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('logo')) {
            $validated['logo'] = $imageService->upload(
                file: $request->file('logo'),
                folder: 'partners',
                maxWidth: 400,
                maxHeight: 200,
                quality: 85,
                generateThumbnail: true
            );
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = $validated['sort_order'] ?? (Partner::max('sort_order') + 1);

        Partner::create($validated);

        return redirect()->route('admin.partners.index')
            ->with('success', 'Partner organization created successfully.');
    }

    public function edit(Partner $partner): View
    {
        return view('admin.partners.edit', compact('partner'));
    }

    public function update(PartnerRequest $request, Partner $partner, ImageUploadService $imageService): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('logo')) {
            $validated['logo'] = $imageService->upload(
                file: $request->file('logo'),
                folder: 'partners',
                oldPath: $partner->logo,
                maxWidth: 400,
                maxHeight: 200,
                quality: 85,
                generateThumbnail: true
            );
        }

        $validated['is_active'] = $request->boolean('is_active', true);

        $partner->update($validated);

        return redirect()->route('admin.partners.index')
            ->with('success', 'Partner organization updated successfully.');
    }

    public function destroy(Partner $partner, ImageUploadService $imageService): RedirectResponse
    {
        if ($partner->logo) {
            $imageService->delete($partner->logo);
        }

        $partner->delete();

        return redirect()->route('admin.partners.index')
            ->with('success', 'Partner organization deleted successfully.');
    }

    public function reorder(Request $request): JsonResponse
    {
        $request->validate([
            'items' => ['required', 'array'],
            'items.*.id' => ['required', 'exists:partners,id'],
            'items.*.sort_order' => ['required', 'integer'],
        ]);

        foreach ($request->input('items') as $item) {
            Partner::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Partner logos order updated successfully.',
        ]);
    }
}


<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BannerRequest;
use App\Models\Banner;
use App\Services\ImageUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BannerController extends Controller
{
    public function index(): View
    {
        $banners = Banner::orderBy('sort_order', 'asc')->get();

        return view('admin.banners.index', compact('banners'));
    }

    public function create(): View
    {
        return view('admin.banners.create');
    }

    public function store(BannerRequest $request, ImageUploadService $imageService): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $imageService->upload(
                file: $request->file('image'),
                folder: 'banners',
                maxWidth: 1920,
                maxHeight: 800,
                quality: 85,
                generateThumbnail: true
            );
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = $validated['sort_order'] ?? (Banner::max('sort_order') + 1);

        Banner::create($validated);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Hero banner created successfully.');
    }

    public function edit(Banner $banner): View
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(BannerRequest $request, Banner $banner, ImageUploadService $imageService): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $imageService->upload(
                file: $request->file('image'),
                folder: 'banners',
                oldPath: $banner->image,
                maxWidth: 1920,
                maxHeight: 800,
                quality: 85,
                generateThumbnail: true
            );
        }

        $validated['is_active'] = $request->boolean('is_active', true);

        $banner->update($validated);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Hero banner updated successfully.');
    }

    public function destroy(Banner $banner, ImageUploadService $imageService): RedirectResponse
    {
        if ($banner->image) {
            $imageService->delete($banner->image);
        }

        $banner->delete();

        return redirect()->route('admin.banners.index')
            ->with('success', 'Hero banner deleted successfully.');
    }

    /**
     * Handle AJAX drag-and-drop row reordering.
     */
    public function reorder(Request $request): JsonResponse
    {
        $request->validate([
            'items' => ['required', 'array'],
            'items.*.id' => ['required', 'exists:banners,id'],
            'items.*.sort_order' => ['required', 'integer'],
        ]);

        foreach ($request->input('items') as $item) {
            Banner::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Banner display order updated successfully.',
        ]);
    }
}

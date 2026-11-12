<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CentreRequest;
use App\Models\Brand;
use App\Models\Centre;
use App\Models\CentreImage;
use App\Models\Course;
use App\Services\ImageUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CentreController extends Controller
{
    public function index(): View
    {
        $centres = Centre::with('brand')
            ->withCount(['courses', 'images'])
            ->orderBy('sort_order', 'asc')
            ->get();

        return view('admin.centres.index', compact('centres'));
    }

    public function create(): View
    {
        $brands = Brand::where('is_active', true)->get();
        $courses = Course::where('is_active', true)->with('brand')->get();

        return view('admin.centres.create', compact('brands', 'courses'));
    }

    public function store(CentreRequest $request, ImageUploadService $imageService): RedirectResponse
    {
        $validated = $request->validated();
        $validated['slug'] = !empty($validated['slug']) ? $validated['slug'] : Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = $validated['sort_order'] ?? (Centre::max('sort_order') + 1);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $imageService->upload(
                file: $request->file('cover_image'),
                folder: 'centres',
                maxWidth: 1200,
                maxHeight: 800,
                quality: 85,
                generateThumbnail: true
            );
        }

        $courseIds = $validated['courses'] ?? [];
        unset($validated['courses'], $validated['gallery_images'], $validated['gallery_captions']);

        $centre = Centre::create($validated);
        $centre->courses()->sync($courseIds);

        // Handle gallery images upload
        if ($request->hasFile('gallery_images')) {
            $captions = $request->input('gallery_captions', []);
            foreach ($request->file('gallery_images') as $index => $file) {
                $path = $imageService->upload(
                    file: $file,
                    folder: 'centres/gallery',
                    maxWidth: 1200,
                    maxHeight: 800,
                    quality: 82,
                    generateThumbnail: true
                );

                CentreImage::create([
                    'centre_id' => $centre->id,
                    'path' => $path,
                    'caption' => $captions[$index] ?? null,
                    'alt_text' => $centre->name,
                    'sort_order' => $index + 1,
                ]);
            }
        }

        return redirect()->route('admin.centres.index')
            ->with('success', 'Network campus centre created successfully.');
    }

    public function edit(Centre $centre): View
    {
        $centre->load(['brand', 'courses', 'images']);
        $brands = Brand::where('is_active', true)->get();
        $courses = Course::where('is_active', true)->with('brand')->get();

        return view('admin.centres.edit', compact('centre', 'brands', 'courses'));
    }

    public function update(CentreRequest $request, Centre $centre, ImageUploadService $imageService): RedirectResponse
    {
        $validated = $request->validated();
        $validated['slug'] = !empty($validated['slug']) ? $validated['slug'] : Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $imageService->upload(
                file: $request->file('cover_image'),
                folder: 'centres',
                oldPath: $centre->cover_image,
                maxWidth: 1200,
                maxHeight: 800,
                quality: 85,
                generateThumbnail: true
            );
        }

        $courseIds = $validated['courses'] ?? [];
        unset($validated['courses'], $validated['gallery_images'], $validated['gallery_captions']);

        $centre->update($validated);
        $centre->courses()->sync($courseIds);

        // Upload additional gallery images if provided
        if ($request->hasFile('gallery_images')) {
            $captions = $request->input('gallery_captions', []);
            $currentMaxOrder = $centre->images()->max('sort_order') ?? 0;

            foreach ($request->file('gallery_images') as $index => $file) {
                $path = $imageService->upload(
                    file: $file,
                    folder: 'centres/gallery',
                    maxWidth: 1200,
                    maxHeight: 800,
                    quality: 82,
                    generateThumbnail: true
                );

                CentreImage::create([
                    'centre_id' => $centre->id,
                    'path' => $path,
                    'caption' => $captions[$index] ?? null,
                    'alt_text' => $centre->name,
                    'sort_order' => $currentMaxOrder + $index + 1,
                ]);
            }
        }

        return redirect()->route('admin.centres.index')
            ->with('success', 'Network campus centre updated successfully.');
    }

    public function destroy(Centre $centre, ImageUploadService $imageService): RedirectResponse
    {
        if ($centre->cover_image) {
            $imageService->delete($centre->cover_image);
        }

        $centre->delete(); // Soft delete

        return redirect()->route('admin.centres.index')
            ->with('success', 'Centre deleted successfully.');
    }

    public function deleteImage(CentreImage $image, ImageUploadService $imageService): RedirectResponse
    {
        $imageService->delete($image->path);
        $image->delete();

        return back()->with('success', 'Campus photo removed successfully.');
    }

    public function reorder(Request $request): JsonResponse
    {
        $request->validate([
            'items' => ['required', 'array'],
            'items.*.id' => ['required', 'exists:centres,id'],
            'items.*.sort_order' => ['required', 'integer'],
        ]);

        foreach ($request->input('items') as $item) {
            Centre::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Centres order updated successfully.',
        ]);
    }
}

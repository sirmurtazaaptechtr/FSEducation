<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MouPartnerRequest;
use App\Models\Brand;
use App\Models\Course;
use App\Models\MouPartner;
use App\Services\ImageUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MouPartnerController extends Controller
{
    public function index(Request $request): View
    {
        $query = MouPartner::with(['brands', 'courses'])
            ->withCount('inquiries');

        if ($request->filled('type')) {
            $query->where('organization_type', $request->input('type'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('referral_code', 'like', "%{$search}%");
            });
        }

        $partners = $query->orderBy('sort_order', 'asc')->get();

        return view('admin.mou-partners.index', compact('partners'));
    }

    public function create(): View
    {
        $brands = Brand::where('is_active', true)->get();
        $courses = Course::where('is_active', true)->with('brand')->orderBy('sort_order', 'asc')->get();

        // Note: $selectedBrandIds is deliberately empty by default
        $selectedBrandIds = [];
        $selectedCourseIds = [];

        return view('admin.mou-partners.create', compact('brands', 'courses', 'selectedBrandIds', 'selectedCourseIds'));
    }

    public function store(MouPartnerRequest $request, ImageUploadService $imageService): RedirectResponse
    {
        $validated = $request->validated();
        $validated['slug'] = !empty($validated['slug']) ? $validated['slug'] : Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['is_featured'] = $request->boolean('is_featured', false);
        $validated['sort_order'] = $validated['sort_order'] ?? (MouPartner::max('sort_order') + 1);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $imageService->upload(
                file: $request->file('logo'),
                folder: 'mous/logos',
                maxWidth: 400,
                maxHeight: 200,
                quality: 85,
                generateThumbnail: true
            );
        }

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $imageService->upload(
                file: $request->file('cover_image'),
                folder: 'mous/covers',
                maxWidth: 1200,
                maxHeight: 630,
                quality: 85,
                generateThumbnail: true
            );
        }

        $brandIds = $validated['brands'] ?? [];
        $courseIds = $validated['courses'] ?? [];
        unset($validated['brands'], $validated['courses']);

        $mouPartner = MouPartner::create($validated);
        $mouPartner->brands()->sync($brandIds);
        $mouPartner->courses()->sync($courseIds);

        return redirect()->route('admin.mou-partners.index')
            ->with('success', 'MOU partner registered successfully.');
    }

    public function edit(MouPartner $mouPartner): View
    {
        $mouPartner->load(['brands', 'courses']);
        $brands = Brand::where('is_active', true)->get();
        $courses = Course::where('is_active', true)->with('brand')->orderBy('sort_order', 'asc')->get();

        $selectedBrandIds = $mouPartner->brands->pluck('id')->toArray();
        $selectedCourseIds = $mouPartner->courses->pluck('id')->toArray();

        return view('admin.mou-partners.edit', compact('mouPartner', 'brands', 'courses', 'selectedBrandIds', 'selectedCourseIds'));
    }

    public function update(MouPartnerRequest $request, MouPartner $mouPartner, ImageUploadService $imageService): RedirectResponse
    {
        $validated = $request->validated();
        $validated['slug'] = !empty($validated['slug']) ? $validated['slug'] : Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['is_featured'] = $request->boolean('is_featured', false);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $imageService->upload(
                file: $request->file('logo'),
                folder: 'mous/logos',
                oldPath: $mouPartner->logo,
                maxWidth: 400,
                maxHeight: 200,
                quality: 85,
                generateThumbnail: true
            );
        }

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $imageService->upload(
                file: $request->file('cover_image'),
                folder: 'mous/covers',
                oldPath: $mouPartner->cover_image,
                maxWidth: 1200,
                maxHeight: 630,
                quality: 85,
                generateThumbnail: true
            );
        }

        $brandIds = $validated['brands'] ?? [];
        $courseIds = $validated['courses'] ?? [];
        unset($validated['brands'], $validated['courses']);

        $mouPartner->update($validated);
        $mouPartner->brands()->sync($brandIds);
        $mouPartner->courses()->sync($courseIds);

        return redirect()->route('admin.mou-partners.index')
            ->with('success', 'MOU partner updated successfully.');
    }

    public function destroy(MouPartner $mouPartner, ImageUploadService $imageService): RedirectResponse
    {
        if ($mouPartner->logo) {
            $imageService->delete($mouPartner->logo);
        }
        if ($mouPartner->cover_image) {
            $imageService->delete($mouPartner->cover_image);
        }

        $mouPartner->delete();

        return redirect()->route('admin.mou-partners.index')
            ->with('success', 'MOU partner deleted successfully.');
    }

    public function reorder(Request $request): JsonResponse
    {
        $request->validate([
            'items' => ['required', 'array'],
            'items.*.id' => ['required', 'exists:mou_partners,id'],
            'items.*.sort_order' => ['required', 'integer'],
        ]);

        foreach ($request->input('items') as $item) {
            MouPartner::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'MOU partners order updated successfully.',
        ]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BrandRequest;
use App\Models\Brand;
use App\Services\ImageUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BrandController extends Controller
{
    public function index(): View
    {
        $brands = Brand::withCount(['centres', 'courses'])->get();

        return view('admin.brands.index', compact('brands'));
    }

    public function create(): View
    {
        return view('admin.brands.create');
    }

    public function store(BrandRequest $request, ImageUploadService $imageService): RedirectResponse
    {
        $validated = $request->validated();
        $validated['slug'] = !empty($validated['slug']) ? $validated['slug'] : Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $imageService->upload(
                file: $request->file('logo'),
                folder: 'brands',
                maxWidth: 400,
                maxHeight: 200,
                quality: 85,
                generateThumbnail: true
            );
        }

        Brand::create($validated);

        return redirect()->route('admin.brands.index')
            ->with('success', 'Brand institution created successfully.');
    }

    public function edit(Brand $brand): View
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(BrandRequest $request, Brand $brand, ImageUploadService $imageService): RedirectResponse
    {
        $validated = $request->validated();
        $validated['slug'] = !empty($validated['slug']) ? $validated['slug'] : Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $imageService->upload(
                file: $request->file('logo'),
                folder: 'brands',
                oldPath: $brand->logo,
                maxWidth: 400,
                maxHeight: 200,
                quality: 85,
                generateThumbnail: true
            );
        }

        $brand->update($validated);

        return redirect()->route('admin.brands.index')
            ->with('success', 'Brand updated successfully.');
    }

    public function destroy(Brand $brand, ImageUploadService $imageService): RedirectResponse
    {
        if ($brand->slug === 'fs-education') {
            return redirect()->route('admin.brands.index')
                ->with('error', 'Cannot delete the primary parent company brand (F.S. Education).');
        }

        if ($brand->centres()->count() > 0 || $brand->courses()->count() > 0) {
            return redirect()->route('admin.brands.index')
                ->with('error', 'Cannot delete brand while centres or courses are assigned to it.');
        }

        if ($brand->logo) {
            $imageService->delete($brand->logo);
        }

        $brand->delete();

        return redirect()->route('admin.brands.index')
            ->with('success', 'Brand deleted successfully.');
    }
}

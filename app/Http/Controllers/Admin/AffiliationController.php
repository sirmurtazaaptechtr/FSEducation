<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AffiliationRequest;
use App\Models\Affiliation;
use App\Services\ImageUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AffiliationController extends Controller
{
    public function index(): View
    {
        $affiliations = Affiliation::withCount('courses')
            ->orderBy('sort_order', 'asc')
            ->get();

        return view('admin.affiliations.index', compact('affiliations'));
    }

    public function create(): View
    {
        return view('admin.affiliations.create');
    }

    public function store(AffiliationRequest $request, ImageUploadService $imageService): RedirectResponse
    {
        $validated = $request->validated();
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = $validated['sort_order'] ?? (Affiliation::max('sort_order') + 1);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $imageService->upload(
                file: $request->file('logo'),
                folder: 'affiliations',
                maxWidth: 400,
                maxHeight: 200,
                quality: 85,
                generateThumbnail: true
            );
        }

        Affiliation::create($validated);

        return redirect()->route('admin.affiliations.index')
            ->with('success', 'Affiliation authority created successfully.');
    }

    public function edit(Affiliation $affiliation): View
    {
        return view('admin.affiliations.edit', compact('affiliation'));
    }

    public function update(AffiliationRequest $request, Affiliation $affiliation, ImageUploadService $imageService): RedirectResponse
    {
        $validated = $request->validated();
        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $imageService->upload(
                file: $request->file('logo'),
                folder: 'affiliations',
                oldPath: $affiliation->logo,
                maxWidth: 400,
                maxHeight: 200,
                quality: 85,
                generateThumbnail: true
            );
        }

        $affiliation->update($validated);

        return redirect()->route('admin.affiliations.index')
            ->with('success', 'Affiliation authority updated successfully.');
    }

    public function destroy(Affiliation $affiliation, ImageUploadService $imageService): RedirectResponse
    {
        if ($affiliation->courses()->count() > 0) {
            return redirect()->route('admin.affiliations.index')
                ->with('error', 'Cannot delete affiliation while approved courses are registered under it.');
        }

        if ($affiliation->logo) {
            $imageService->delete($affiliation->logo);
        }

        $affiliation->delete();

        return redirect()->route('admin.affiliations.index')
            ->with('success', 'Affiliation authority deleted successfully.');
    }

    public function reorder(Request $request): JsonResponse
    {
        $request->validate([
            'items' => ['required', 'array'],
            'items.*.id' => ['required', 'exists:affiliations,id'],
            'items.*.sort_order' => ['required', 'integer'],
        ]);

        foreach ($request->input('items') as $item) {
            Affiliation::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Affiliations order updated successfully.',
        ]);
    }
}


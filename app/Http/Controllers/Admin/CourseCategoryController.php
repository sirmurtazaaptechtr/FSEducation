<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CourseCategoryRequest;
use App\Models\CourseCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CourseCategoryController extends Controller
{
    public function index(): View
    {
        $categories = CourseCategory::withCount('courses')
            ->orderBy('sort_order', 'asc')
            ->get();

        return view('admin.course-categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.course-categories.create');
    }

    public function store(CourseCategoryRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['slug'] = !empty($validated['slug']) ? $validated['slug'] : Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = $validated['sort_order'] ?? (CourseCategory::max('sort_order') + 1);

        CourseCategory::create($validated);

        return redirect()->route('admin.course-categories.index')
            ->with('success', 'Course category created successfully.');
    }

    public function edit(CourseCategory $courseCategory): View
    {
        return view('admin.course-categories.edit', compact('courseCategory'));
    }

    public function update(CourseCategoryRequest $request, CourseCategory $courseCategory): RedirectResponse
    {
        $validated = $request->validated();
        $validated['slug'] = !empty($validated['slug']) ? $validated['slug'] : Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active', true);

        $courseCategory->update($validated);

        return redirect()->route('admin.course-categories.index')
            ->with('success', 'Course category updated successfully.');
    }

    public function destroy(CourseCategory $courseCategory): RedirectResponse
    {
        if ($courseCategory->courses()->count() > 0) {
            return redirect()->route('admin.course-categories.index')
                ->with('error', 'Cannot delete category while courses are assigned to it.');
        }

        $courseCategory->delete();

        return redirect()->route('admin.course-categories.index')
            ->with('success', 'Course category deleted successfully.');
    }

    public function reorder(Request $request): JsonResponse
    {
        $request->validate([
            'items' => ['required', 'array'],
            'items.*.id' => ['required', 'exists:course_categories,id'],
            'items.*.sort_order' => ['required', 'integer'],
        ]);

        foreach ($request->input('items') as $item) {
            CourseCategory::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Categories order updated successfully.',
        ]);
    }
}

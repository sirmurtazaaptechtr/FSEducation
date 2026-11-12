<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CourseRequest;
use App\Models\Affiliation;
use App\Models\Brand;
use App\Models\Centre;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Services\ImageUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function index(Request $request): View
    {
        $query = Course::with(['brand', 'category', 'affiliation', 'centres'])
            ->withCount('inquiries');

        // Search query
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('registration_reference', 'like', "%{$search}%");
            });
        }

        // Brand filter
        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->input('brand_id'));
        }

        // Category filter
        if ($request->filled('category_id')) {
            $query->where('course_category_id', $request->input('category_id'));
        }

        // Approval status filter
        if ($request->filled('approval_status')) {
            $query->where('approval_status', $request->input('approval_status'));
        }

        // Affiliation filter
        if ($request->filled('affiliation_id')) {
            $query->where('affiliation_id', $request->input('affiliation_id'));
        }

        $courses = $query->orderBy('sort_order', 'asc')->paginate(15)->withQueryString();

        $brands = Brand::where('is_active', true)->get();
        $categories = CourseCategory::where('is_active', true)->get();
        $affiliations = Affiliation::where('is_active', true)->get();

        return view('admin.courses.index', compact('courses', 'brands', 'categories', 'affiliations'));
    }

    public function create(): View
    {
        $brands = Brand::where('is_active', true)->get();
        $categories = CourseCategory::where('is_active', true)->orderBy('sort_order', 'asc')->get();
        $affiliations = Affiliation::where('is_active', true)->orderBy('sort_order', 'asc')->get();
        $centres = Centre::where('is_active', true)->with('brand')->orderBy('sort_order', 'asc')->get();

        return view('admin.courses.create', compact('brands', 'categories', 'affiliations', 'centres'));
    }

    public function store(CourseRequest $request, ImageUploadService $imageService): RedirectResponse
    {
        $validated = $request->validated();
        $validated['slug'] = !empty($validated['slug']) ? $validated['slug'] : Str::slug($validated['title']);
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['is_featured'] = $request->boolean('is_featured', false);
        $validated['sort_order'] = $validated['sort_order'] ?? (Course::max('sort_order') + 1);

        if ($request->hasFile('image')) {
            $validated['image'] = $imageService->upload(
                file: $request->file('image'),
                folder: 'courses',
                maxWidth: 1200,
                maxHeight: 800,
                quality: 85,
                generateThumbnail: true
            );
        }

        $centreIds = $validated['centres'] ?? [];
        unset($validated['centres']);

        $course = Course::create($validated);
        $course->centres()->sync($centreIds);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course / Programme registered successfully.');
    }

    public function edit(Course $course): View
    {
        $course->load(['brand', 'category', 'affiliation', 'centres']);

        $brands = Brand::where('is_active', true)->get();
        $categories = CourseCategory::where('is_active', true)->orderBy('sort_order', 'asc')->get();
        $affiliations = Affiliation::where('is_active', true)->orderBy('sort_order', 'asc')->get();
        $centres = Centre::where('is_active', true)->with('brand')->orderBy('sort_order', 'asc')->get();

        return view('admin.courses.edit', compact('course', 'brands', 'categories', 'affiliations', 'centres'));
    }

    public function update(CourseRequest $request, Course $course, ImageUploadService $imageService): RedirectResponse
    {
        $validated = $request->validated();
        $validated['slug'] = !empty($validated['slug']) ? $validated['slug'] : Str::slug($validated['title']);
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['is_featured'] = $request->boolean('is_featured', false);

        if ($request->hasFile('image')) {
            $validated['image'] = $imageService->upload(
                file: $request->file('image'),
                folder: 'courses',
                oldPath: $course->image,
                maxWidth: 1200,
                maxHeight: 800,
                quality: 85,
                generateThumbnail: true
            );
        }

        $centreIds = $validated['centres'] ?? [];
        unset($validated['centres']);

        $course->update($validated);
        $course->centres()->sync($centreIds);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course, ImageUploadService $imageService): RedirectResponse
    {
        if ($course->image) {
            $imageService->delete($course->image);
        }

        $course->delete(); // Soft delete

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course deleted successfully.');
    }

    public function reorder(Request $request): JsonResponse
    {
        $request->validate([
            'items' => ['required', 'array'],
            'items.*.id' => ['required', 'exists:courses,id'],
            'items.*.sort_order' => ['required', 'integer'],
        ]);

        foreach ($request->input('items') as $item) {
            Course::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Courses order updated successfully.',
        ]);
    }
}

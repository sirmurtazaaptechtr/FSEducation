<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Affiliation;
use App\Models\Brand;
use App\Models\Centre;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\MouPartner;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CourseController extends Controller
{
    /**
     * Display course and programme catalogue with filtering.
     */
    public function index(Request $request): View
    {
        $selectedBrand = $request->query('brand');
        $selectedCategory = $request->query('category');
        $selectedCentre = $request->query('centre');
        $selectedAffiliation = $request->query('affiliation');
        $searchQuery = $request->query('q');

        $query = Course::with(['brand', 'affiliation', 'category', 'centres'])
            ->active()
            ->orderBy('sort_order');

        if ($selectedBrand) {
            $query->whereHas('brand', function ($q) use ($selectedBrand) {
                $q->where('slug', $selectedBrand);
            });
        }

        if ($selectedCategory) {
            $query->whereHas('category', function ($q) use ($selectedCategory) {
                $q->where('slug', $selectedCategory);
            });
        }

        if ($selectedCentre) {
            $query->whereHas('centres', function ($q) use ($selectedCentre) {
                $q->where('centres.id', $selectedCentre);
            });
        }

        if ($selectedAffiliation) {
            $query->whereHas('affiliation', function ($q) use ($selectedAffiliation) {
                $q->where('short_name', $selectedAffiliation);
            });
        }

        if ($searchQuery) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('title', 'like', "%{$searchQuery}%")
                  ->orWhere('short_description', 'like', "%{$searchQuery}%")
                  ->orWhere('description', 'like', "%{$searchQuery}%");
            });
        }

        $courses = $query->get();

        // Data for filters
        $brands = Brand::where('is_active', true)->orderBy('name')->get();
        $categories = CourseCategory::where('is_active', true)->orderBy('sort_order')->get();
        $centres = Centre::active()->orderBy('name')->get();
        $affiliations = Affiliation::active()->orderBy('sort_order')->get();

        return view('public.courses.index', compact(
            'courses',
            'brands',
            'categories',
            'centres',
            'affiliations',
            'selectedBrand',
            'selectedCategory',
            'selectedCentre',
            'selectedAffiliation',
            'searchQuery'
        ));
    }

    /**
     * Display a single course / programme detail page.
     */
    public function show(string $slug): View
    {
        $course = Course::where('slug', $slug)
            ->active()
            ->with(['brand', 'affiliation', 'category', 'centres' => function ($q) {
                $q->active()->orderBy('sort_order');
            }])
            ->firstOrFail();

        // Determine applicable active MOUs for this course or its brand
        $applicableMous = MouPartner::active()
            ->where(function ($q) use ($course) {
                $q->whereHas('brands', function ($b) use ($course) {
                    $b->where('brands.id', $course->brand_id);
                })
                ->orWhereHas('courses', function ($c) use ($course) {
                    $c->where('courses.id', $course->id);
                });
            })
            ->get();

        // Related courses from the same brand or category
        $relatedCourses = Course::where('id', '!=', $course->id)
            ->where('brand_id', $course->brand_id)
            ->active()
            ->with(['brand', 'affiliation', 'category'])
            ->take(3)
            ->get();

        return view('public.courses.show', compact('course', 'applicableMous', 'relatedCourses'));
    }
}


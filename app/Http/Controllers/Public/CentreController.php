<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Centre;
use App\Models\Course;
use App\Models\MouPartner;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CentreController extends Controller
{
    /**
     * Display listing of educational centres / campuses.
     */
    public function index(Request $request): View
    {
        $selectedBrandSlug = $request->query('brand');

        $brands = Brand::where('is_active', true)->orderBy('name')->get();

        $centresQuery = Centre::with(['brand'])
            ->withCount(['courses' => function ($q) {
                $q->active();
            }])
            ->active()
            ->orderBy('sort_order');

        if ($selectedBrandSlug) {
            $centresQuery->whereHas('brand', function ($q) use ($selectedBrandSlug) {
                $q->where('slug', $selectedBrandSlug);
            });
        }

        $centres = $centresQuery->get();

        return view('public.centres.index', compact('centres', 'brands', 'selectedBrandSlug'));
    }

    /**
     * Display a single centre's detail page.
     */
    public function show(string $slug): View
    {
        $centre = Centre::where('slug', $slug)
            ->active()
            ->with([
                'brand',
                'images' => function ($q) {
                    $q->orderBy('sort_order');
                },
                'courses' => function ($q) {
                    $q->active()->with(['brand', 'affiliation', 'category'])->orderBy('sort_order');
                },
            ])
            ->firstOrFail();

        // Get active courses offered at this centre for the quick inquiry form
        $courses = $centre->courses;

        // Get active MOU partners for student discount inquiry
        $mouPartners = MouPartner::active()->orderBy('name')->get();

        return view('public.centres.show', compact('centre', 'courses', 'mouPartners'));
    }
}


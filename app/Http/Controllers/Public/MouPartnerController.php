<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Centre;
use App\Models\Course;
use App\Models\MouPartner;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MouPartnerController extends Controller
{
    /**
     * Display public listing of active MOU partner organizations with student discounts.
     */
    public function index(Request $request): View
    {
        $partners = MouPartner::active()
            ->with(['brands', 'courses'])
            ->orderBy('sort_order')
            ->get();

        $brands = Brand::where('is_active', true)->get();

        return view('public.mou-partners.index', compact('partners', 'brands'));
    }

    /**
     * Display detail page of an MOU partner, discount terms, and how to avail.
     */
    public function show(string $slug): View
    {
        $partner = MouPartner::where('slug', $slug)
            ->active()
            ->with(['brands', 'courses.brand'])
            ->firstOrFail();

        // Get applicable centres based on brands attached to the MOU
        $brandIds = $partner->brands->pluck('id');
        $applicableCentres = Centre::active()
            ->when($brandIds->isNotEmpty(), function ($q) use ($brandIds) {
                $q->whereIn('brand_id', $brandIds);
            })
            ->with('brand')
            ->orderBy('sort_order')
            ->get();

        // Get all courses from applicable brands or specific courses attached
        $applicableCourses = Course::active()
            ->when($brandIds->isNotEmpty(), function ($q) use ($brandIds) {
                $q->whereIn('brand_id', $brandIds);
            })
            ->with('brand')
            ->orderBy('sort_order')
            ->get();

        return view('public.mou-partners.show', compact('partner', 'applicableCentres', 'applicableCourses'));
    }
}

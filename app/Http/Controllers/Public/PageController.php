<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Affiliation;
use App\Models\Brand;
use App\Models\Course;
use App\Models\Page;
use App\Models\Stat;
use App\Models\Testimonial;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * About F.S. Education page.
     */
    public function about(): View
    {
        $page = Page::where('slug', 'about')->firstOrFail();
        $stats = Stat::active()->orderBy('sort_order')->get();

        return view('public.pages.about', compact('page', 'stats'));
    }

    /**
     * Vision & Mission page.
     */
    public function visionMission(): View
    {
        $page = Page::where('slug', 'vision-mission')->firstOrFail();

        return view('public.pages.vision-mission', compact('page'));
    }

    /**
     * Our Educational Network overview page (all 5 centres grouped by brand).
     */
    public function network(): View
    {
        $page = Page::where('slug', 'network')->firstOrFail();
        $brands = Brand::with(['centres' => function ($q) {
            $q->active()->orderBy('sort_order');
        }])->where('is_active', true)->get();

        return view('public.pages.network', compact('page', 'brands'));
    }

    /**
     * Why Choose Us page.
     */
    public function whyUs(): View
    {
        $page = Page::where('slug', 'why-us')->firstOrFail();
        $stats = Stat::active()->orderBy('sort_order')->get();
        $testimonials = Testimonial::active()->orderBy('sort_order')->take(4)->get();

        return view('public.pages.why-us', compact('page', 'stats', 'testimonials'));
    }

    /**
     * Leadership Message page.
     */
    public function leadershipMessage(): View
    {
        $page = Page::where('slug', 'leadership-message')->firstOrFail();

        return view('public.pages.leadership-message', compact('page'));
    }

    /**
     * Accreditations & Affiliations (SBTE / NAVTTC) transparency page.
     */
    public function accreditations(): View
    {
        $page = Page::where('slug', 'accreditations')->firstOrFail();
        $affiliations = Affiliation::active()->orderBy('sort_order')->get();

        // Strictly fetch approved F.S. Education courses with affiliations
        $approvedCourses = Course::whereHas('brand', function ($q) {
            $q->where('slug', 'fs-education');
        })
        ->where('approval_status', 'approved')
        ->with(['brand', 'affiliation', 'centres'])
        ->active()
        ->orderBy('sort_order')
        ->get();

        return view('public.pages.accreditations', compact('page', 'affiliations', 'approvedCourses'));
    }
}

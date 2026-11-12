<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Affiliation;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Course;
use App\Models\MouPartner;
use App\Models\NewsPost;
use App\Models\Stat;
use App\Models\Testimonial;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the 11-section marketing homepage.
     */
    public function index(): View
    {
        $banners = Banner::active()->orderBy('sort_order')->get();
        $stats = Stat::active()->orderBy('sort_order')->get();

        // Network brands with active centres
        $brands = Brand::with(['centres' => function ($q) {
            $q->active()->orderBy('sort_order');
        }])->where('is_active', true)->get();

        // Featured courses with eager loaded relations
        $featuredCourses = Course::with(['brand', 'affiliation', 'category', 'centres'])
            ->active()
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        // Active and featured MOU partners
        $featuredMous = MouPartner::active()
            ->with('brands')
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->take(4)
            ->get();

        // Affiliations (SBTE, NAVTTC)
        $affiliations = Affiliation::active()->orderBy('sort_order')->get();

        // Latest news posts
        $latestNews = NewsPost::active()->latest('published_at')->take(3)->get();

        // Testimonials
        $testimonials = Testimonial::active()->orderBy('sort_order')->take(6)->get();

        return view('public.home', compact(
            'banners',
            'stats',
            'brands',
            'featuredCourses',
            'featuredMous',
            'affiliations',
            'latestNews',
            'testimonials'
        ));
    }
}

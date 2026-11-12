<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Centre;
use App\Models\Course;
use App\Models\MouPartner;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * Display contact page with campus locations, phone/whatsapp, and direct inquiry form.
     */
    public function index(): View
    {
        $centres = Centre::with('brand')->active()->orderBy('sort_order')->get();
        $courses = Course::with('brand')->active()->orderBy('sort_order')->get();
        $mouPartners = MouPartner::active()->orderBy('name')->get();

        return view('public.contact', compact('centres', 'courses', 'mouPartners'));
    }
}

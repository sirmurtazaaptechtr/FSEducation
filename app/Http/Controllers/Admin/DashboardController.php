<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Centre;
use App\Models\Course;
use App\Models\Inquiry;
use App\Models\MouPartner;
use App\Models\PartnerRequest;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $now = Carbon::now();

        $metrics = [
            'total_centres' => Centre::count(),
            'total_courses' => Course::count(),
            'active_mous' => MouPartner::active()->count(),
            'total_inquiries' => Inquiry::count(),
            'new_inquiries' => Inquiry::where('status', 'new')->count(),
            'mou_inquiries_month' => Inquiry::whereNotNull('mou_partner_id')
                ->whereBetween('created_at', [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()])
                ->count(),
            'active_banners' => Banner::active()->count(),
            'new_partner_requests' => PartnerRequest::where('status', 'new')->count(),
        ];

        $recentInquiries = Inquiry::with(['course', 'centre', 'mouPartner'])
            ->latest()
            ->take(6)
            ->get();

        $recentPartnerRequests = PartnerRequest::latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('metrics', 'recentInquiries', 'recentPartnerRequests'));
    }
}

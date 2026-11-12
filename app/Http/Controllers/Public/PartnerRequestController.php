<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\Public\PartnerRequestFormRequest;
use App\Models\PartnerRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PartnerRequestController extends Controller
{
    /**
     * Show the Become a Partner / MOU Inquiry application form.
     */
    public function showForm(): View
    {
        return view('public.pages.become-a-partner');
    }

    /**
     * Store a partner partnership request.
     */
    public function submit(PartnerRequestFormRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        PartnerRequest::create([
            'organization_name' => $validated['organization_name'],
            'contact_person' => $validated['contact_person'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'message' => $validated['message'] ?? null,
            'status' => 'new',
        ]);

        return back()->with('success', 'Thank you! Your partnership inquiry has been submitted. Our Institutional Partnerships team will contact you shortly.');
    }
}

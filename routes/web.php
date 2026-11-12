<?php

use App\Http\Controllers\Admin\AffiliationController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CentreController as AdminCentreController;
use App\Http\Controllers\Admin\CourseCategoryController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MouPartnerController as AdminMouPartnerController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StatController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\CentreController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Public\CourseController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\InquiryController;
use App\Http\Controllers\Public\MouPartnerController;
use App\Http\Controllers\Public\PageController;
use App\Http\Controllers\Public\PartnerRequestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// 1. PUBLIC MARKETING WEBSITE
// ==========================================

// Homepage (11-section hierarchy)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Group Institutional Pages (from database pages table)
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/vision-mission', [PageController::class, 'visionMission'])->name('vision-mission');
Route::get('/network', [PageController::class, 'network'])->name('network');
Route::get('/why-us', [PageController::class, 'whyUs'])->name('why-us');
Route::get('/leadership-message', [PageController::class, 'leadershipMessage'])->name('leadership-message');
Route::get('/accreditations', [PageController::class, 'accreditations'])->name('accreditations');

// Centres / Campuses
Route::get('/centres', [CentreController::class, 'index'])->name('centres.index');
Route::get('/centres/{slug}', [CentreController::class, 'show'])->name('centres.show');

// Courses & Programmes
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{slug}', [CourseController::class, 'show'])->name('courses.show');

// MOU Partners & Student Discounts
Route::get('/mou-partners', [MouPartnerController::class, 'index'])->name('mou-partners.index');
Route::get('/mou-partners/{slug}', [MouPartnerController::class, 'show'])->name('mou-partners.show');

// Become a Partner / MOU Collaboration
Route::get('/become-a-partner', [PartnerRequestController::class, 'showForm'])->name('partner-request.form');
Route::post('/become-a-partner', [PartnerRequestController::class, 'submit'])
    ->middleware('throttle:10,1')
    ->name('partner-request.submit');

// Contact Admissions
Route::get('/contact', [ContactController::class, 'index'])->name('contact');

// Public Admissions & Discount Inquiries (with UTM / Marketing Attribution & Rate Limiting)
Route::post('/inquiries', [InquiryController::class, 'submit'])
    ->middleware('throttle:15,1')
    ->name('inquiries.submit');


// ==========================================
// 2. AUTHENTICATION & DASHBOARD REDIRECT
// ==========================================

// Redirect generic /dashboard to /admin/dashboard
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth'])->name('dashboard');

// Breeze Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// ==========================================
// 3. ADMIN PANEL ROUTE GROUP
// ==========================================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin,editor'])->group(function () {
    // 1. Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 2. Hero Marketing Banners
    Route::post('/banners/reorder', [BannerController::class, 'reorder'])->name('banners.reorder');
    Route::resource('banners', BannerController::class);

    // 3. Brands
    Route::resource('brands', BrandController::class);

    // 4. Affiliations (SBTE / NAVTTC)
    Route::post('/affiliations/reorder', [AffiliationController::class, 'reorder'])->name('affiliations.reorder');
    Route::resource('affiliations', AffiliationController::class);

    // 5. Centres (5 Campuses)
    Route::post('/centres/reorder', [AdminCentreController::class, 'reorder'])->name('centres.reorder');
    Route::delete('/centres/images/{image}', [AdminCentreController::class, 'deleteImage'])->name('centres.images.destroy');
    Route::resource('centres', AdminCentreController::class);

    // 6. Course Categories
    Route::post('/course-categories/reorder', [CourseCategoryController::class, 'reorder'])->name('course-categories.reorder');
    Route::resource('course-categories', CourseCategoryController::class);

    // 7. Courses & Programmes
    Route::post('/courses/reorder', [AdminCourseController::class, 'reorder'])->name('courses.reorder');
    Route::resource('courses', AdminCourseController::class);

    // 8. MOU Partners
    Route::post('/mou-partners/reorder', [AdminMouPartnerController::class, 'reorder'])->name('mou-partners.reorder');
    Route::resource('mou-partners', AdminMouPartnerController::class);

    // 9. Key Figures (Stats)
    Route::post('/stats/reorder', [StatController::class, 'reorder'])->name('stats.reorder');
    Route::resource('stats', StatController::class);

    // 10. General Partners & Accreditations
    Route::post('/partners/reorder', [PartnerController::class, 'reorder'])->name('partners.reorder');
    Route::resource('partners', PartnerController::class);

    // 11. Site Settings (Restricted to Admin Role Only)
    Route::middleware('role:admin')->group(function () {
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    });

    // Stubs for Phase 5 content modules so layout sidebar links resolve cleanly
    Route::get('/partner-requests', fn () => redirect()->route('admin.dashboard'))->name('partner-requests.index');
    Route::get('/inquiries', fn () => redirect()->route('admin.dashboard'))->name('inquiries.index');
    Route::get('/reports', fn () => redirect()->route('admin.dashboard'))->name('reports.index');
    Route::get('/pages', fn () => redirect()->route('admin.dashboard'))->name('pages.index');
    Route::get('/news', fn () => redirect()->route('admin.dashboard'))->name('news.index');
    Route::get('/gallery', fn () => redirect()->route('admin.dashboard'))->name('gallery.index');
    Route::get('/testimonials', fn () => redirect()->route('admin.dashboard'))->name('testimonials.index');
    Route::get('/team', fn () => redirect()->route('admin.dashboard'))->name('team.index');
    Route::get('/users', fn () => redirect()->route('admin.dashboard'))->name('users.index');
});

require __DIR__.'/auth.php';

<?php

use App\Http\Controllers\Admin\AffiliationController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CentreController;
use App\Http\Controllers\Admin\CourseCategoryController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MouPartnerController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StatController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Website Routes (Foundation)
Route::get('/', function () {
    return view('welcome');
})->name('home');

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

// Admin Panel Route Group
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
    Route::post('/centres/reorder', [CentreController::class, 'reorder'])->name('centres.reorder');
    Route::delete('/centres/images/{image}', [CentreController::class, 'deleteImage'])->name('centres.images.destroy');
    Route::resource('centres', CentreController::class);

    // 6. Course Categories
    Route::post('/course-categories/reorder', [CourseCategoryController::class, 'reorder'])->name('course-categories.reorder');
    Route::resource('course-categories', CourseCategoryController::class);

    // 7. Courses & Programmes
    Route::post('/courses/reorder', [CourseController::class, 'reorder'])->name('courses.reorder');
    Route::resource('courses', CourseController::class);

    // 8. MOU Partners
    Route::post('/mou-partners/reorder', [MouPartnerController::class, 'reorder'])->name('mou-partners.reorder');
    Route::resource('mou-partners', MouPartnerController::class);

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

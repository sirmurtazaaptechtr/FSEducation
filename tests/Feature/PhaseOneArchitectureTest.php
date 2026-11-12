<?php

namespace Tests\Feature;

use App\Models\Affiliation;
use App\Models\Brand;
use App\Models\Centre;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\MouPartner;
use App\Models\Setting;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;
use Tests\TestCase;

class PhaseOneArchitectureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_admin_user_is_seeded_and_can_authenticate(): void
    {
        $this->assertDatabaseHas('users', [
            'email' => 'admin@fseducation.pk',
            'role' => 'admin',
            'is_active' => true,
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@fseducation.pk',
            'password' => 'AdminPassword2026!',
        ]);

        $this->assertAuthenticated();
    }

    public function test_inactive_user_cannot_access_protected_areas(): void
    {
        $inactiveUser = User::factory()->create([
            'email' => 'blocked@fseducation.pk',
            'password' => bcrypt('secret123'),
            'role' => 'editor',
            'is_active' => false,
        ]);

        $this->actingAs($inactiveUser);

        // Simulated check through role middleware
        $middleware = new \App\Http\Middleware\EnsureUserHasRole();
        $request = \Illuminate\Http\Request::create('/admin/dashboard', 'GET');
        $request->setUserResolver(fn () => $inactiveUser);

        $this->expectException(\Symfony\Component\HttpKernel\Exception\HttpException::class);
        $middleware->handle($request, fn () => response('OK'), 'admin', 'editor');
    }

    public function test_editor_is_forbidden_from_admin_only_roles(): void
    {
        $editor = User::where('role', 'editor')->first();
        $this->assertNotNull($editor);

        $middleware = new \App\Http\Middleware\EnsureUserHasRole();
        $request = \Illuminate\Http\Request::create('/admin/settings', 'GET');
        $request->setUserResolver(fn () => $editor);

        $this->expectException(\Symfony\Component\HttpKernel\Exception\HttpException::class);
        // Only admin role allowed here
        $middleware->handle($request, fn () => response('OK'), 'admin');
    }

    public function test_settings_helper_retrieves_seeded_company_name_and_tagline(): void
    {
        $this->assertEquals('F.S. Education', setting('company_name'));
        $this->assertEquals('Learn Today. Lead Tomorrow.', setting('tagline'));
    }

    public function test_three_brands_and_five_centres_are_seeded(): void
    {
        $this->assertDatabaseCount('brands', 3);
        $this->assertDatabaseCount('centres', 5);

        $fsBrand = Brand::where('slug', 'fs-education')->first();
        $this->assertNotNull($fsBrand);
        $this->assertTrue($fsBrand->isFsEducation());
        $this->assertFalse($fsBrand->isFranchise());

        $aptech = Brand::where('slug', 'aptech')->first();
        $this->assertTrue($aptech->isFranchise());
    }

    public function test_fs_education_course_can_have_affiliation(): void
    {
        $fsBrand = Brand::where('slug', 'fs-education')->first();
        $category = CourseCategory::first();
        $sbte = Affiliation::where('short_name', 'SBTE')->first();

        $course = Course::create([
            'brand_id' => $fsBrand->id,
            'course_category_id' => $category->id,
            'affiliation_id' => $sbte->id,
            'title' => 'Test SBTE Diploma',
            'slug' => 'test-sbte-diploma',
            'approval_status' => 'approved',
            'registration_reference' => 'TEST/SBTE/01',
        ]);

        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'affiliation_id' => $sbte->id,
            'approval_status' => 'approved',
        ]);
        $this->assertTrue($course->isApproved());
    }

    public function test_strict_rule_aptech_and_arena_courses_cannot_carry_affiliation(): void
    {
        $aptechBrand = Brand::where('slug', 'aptech')->first();
        $category = CourseCategory::first();
        $sbte = Affiliation::where('short_name', 'SBTE')->first();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Affiliations (SBTE/NAVTTC) are strictly restricted to F.S. Education programmes');

        Course::create([
            'brand_id' => $aptechBrand->id,
            'course_category_id' => $category->id,
            'affiliation_id' => $sbte->id,
            'title' => 'Invalid Franchise Course With Affiliation',
            'slug' => 'invalid-franchise-course',
        ]);
    }

    public function test_active_mou_scope_excludes_expired_and_scheduled_mous(): void
    {
        $activeCount = MouPartner::active()->count();
        $totalCount = MouPartner::count();

        // Total 6 seeded: 4 currently active, 1 scheduled in future, 1 expired in past
        $this->assertEquals(6, $totalCount);
        $this->assertEquals(4, $activeCount);

        $expired = MouPartner::where('slug', 'legacy-retailers-association')->first();
        $this->assertEquals('Expired', $expired->status);
        $this->assertFalse($expired->isValidNow());

        $scheduled = MouPartner::where('slug', 'pasha-skills-future-mou')->first();
        $this->assertEquals('Scheduled', $scheduled->status);
        $this->assertFalse($scheduled->isValidNow());

        $hbl = MouPartner::where('slug', 'hbl-corporate-partnership')->first();
        $this->assertEquals('Active', $hbl->status);
        $this->assertTrue($hbl->isValidNow());
    }
}

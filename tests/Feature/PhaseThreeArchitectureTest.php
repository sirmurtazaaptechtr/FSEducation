<?php

namespace Tests\Feature;

use App\Models\Affiliation;
use App\Models\Brand;
use App\Models\Centre;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\MouPartner;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PhaseThreeArchitectureTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);

        $this->admin = User::where('role', 'admin')->first();
    }

    public function test_brand_crud(): void
    {
        Storage::fake('public');
        $logo = UploadedFile::fake()->image('brand.png', 400, 200);

        // 1. Create Brand
        $response = $this->actingAs($this->admin)->post('/admin/brands', [
            'name' => 'SkillTech Academy',
            'logo' => $logo,
            'description' => 'Technical vocational test brand.',
            'is_active' => '1',
        ]);

        $response->assertRedirect('/admin/brands');
        $this->assertDatabaseHas('brands', [
            'name' => 'SkillTech Academy',
            'slug' => 'skilltech-academy',
        ]);

        $brand = Brand::where('slug', 'skilltech-academy')->first();

        // 2. Edit Brand
        $editResponse = $this->actingAs($this->admin)->put("/admin/brands/{$brand->id}", [
            'name' => 'SkillTech Academy Global',
            'slug' => 'skilltech-academy-global',
            'description' => 'Updated brand description.',
            'is_active' => '1',
        ]);

        $editResponse->assertRedirect('/admin/brands');
        $this->assertDatabaseHas('brands', ['name' => 'SkillTech Academy Global']);

        // 3. Delete Brand
        $deleteResponse = $this->actingAs($this->admin)->delete("/admin/brands/{$brand->id}");
        $deleteResponse->assertRedirect('/admin/brands');
        $this->assertDatabaseMissing('brands', ['id' => $brand->id]);
    }

    public function test_centre_crud_with_course_sync_and_soft_delete(): void
    {
        Storage::fake('public');
        $cover = UploadedFile::fake()->image('campus_cover.jpg', 1200, 800);
        $fsBrand = Brand::where('slug', 'fs-education')->first();
        $course = Course::first();

        // 1. Create Centre
        $response = $this->actingAs($this->admin)->post('/admin/centres', [
            'brand_id' => $fsBrand->id,
            'name' => 'F.S. Education Malir Campus',
            'area' => 'Malir Cantt',
            'city' => 'Karachi',
            'phone' => '+92 21 3456 7890',
            'whatsapp' => '923009998877',
            'cover_image' => $cover,
            'courses' => [$course->id],
            'is_active' => '1',
        ]);

        $response->assertRedirect('/admin/centres');
        $this->assertDatabaseHas('centres', [
            'name' => 'F.S. Education Malir Campus',
            'area' => 'Malir Cantt',
        ]);

        $centre = Centre::where('name', 'F.S. Education Malir Campus')->first();
        $this->assertCount(1, $centre->courses);

        // 2. Soft delete centre
        $deleteResponse = $this->actingAs($this->admin)->delete("/admin/centres/{$centre->id}");
        $deleteResponse->assertRedirect('/admin/centres');

        $this->assertSoftDeleted('centres', ['id' => $centre->id]);
    }

    public function test_course_creation_with_valid_fs_education_affiliation_succeeds(): void
    {
        $fsBrand = Brand::where('slug', 'fs-education')->first();
        $category = CourseCategory::first();
        $sbte = Affiliation::where('short_name', 'SBTE')->first();
        $centre = Centre::first();

        $response = $this->actingAs($this->admin)->post('/admin/courses', [
            'brand_id' => $fsBrand->id,
            'course_category_id' => $category->id,
            'affiliation_id' => $sbte->id,
            'title' => 'Certificate in Artificial Intelligence Systems',
            'duration' => '6 Months',
            'approval_status' => 'approved',
            'registration_reference' => 'SBTE/AI/2026-101',
            'centres' => [$centre->id],
            'is_active' => '1',
        ]);

        $response->assertRedirect('/admin/courses');
        $this->assertDatabaseHas('courses', [
            'title' => 'Certificate in Artificial Intelligence Systems',
            'affiliation_id' => $sbte->id,
            'approval_status' => 'approved',
        ]);
    }

    public function test_strict_rule_validation_rejects_aptech_course_with_affiliation(): void
    {
        $aptechBrand = Brand::where('slug', 'aptech')->first();
        $category = CourseCategory::first();
        $sbte = Affiliation::where('short_name', 'SBTE')->first();

        // Attempting to save an Aptech course with SBTE affiliation must trigger validation error
        $response = $this->actingAs($this->admin)->post('/admin/courses', [
            'brand_id' => $aptechBrand->id,
            'course_category_id' => $category->id,
            'affiliation_id' => $sbte->id,
            'title' => 'Aptech Course With Illegal Affiliation',
            'approval_status' => 'none',
        ]);

        $response->assertSessionHasErrors('affiliation_id');
        $this->assertDatabaseMissing('courses', [
            'title' => 'Aptech Course With Illegal Affiliation',
        ]);
    }

    public function test_strict_rule_validation_rejects_arena_course_with_affiliation(): void
    {
        $arenaBrand = Brand::where('slug', 'arena-multimedia')->first();
        $category = CourseCategory::first();
        $navttc = Affiliation::where('short_name', 'NAVTTC')->first();

        $response = $this->actingAs($this->admin)->post('/admin/courses', [
            'brand_id' => $arenaBrand->id,
            'course_category_id' => $category->id,
            'affiliation_id' => $navttc->id,
            'title' => 'Arena Course With Illegal Affiliation',
            'approval_status' => 'none',
        ]);

        $response->assertSessionHasErrors('affiliation_id');
        $this->assertDatabaseMissing('courses', [
            'title' => 'Arena Course With Illegal Affiliation',
        ]);
    }

    public function test_mou_partner_creation_and_pivot_management(): void
    {
        Storage::fake('public');
        $logo = UploadedFile::fake()->image('mou_logo.png', 400, 200);
        $fsBrand = Brand::where('slug', 'fs-education')->first();
        $course = Course::first();

        // Test creating MOU Partner
        $response = $this->actingAs($this->admin)->post('/admin/mou-partners', [
            'name' => 'Engro Corporation Corporate Benefit',
            'organization_type' => 'corporate',
            'short_description' => '25% tuition fee waiver for Engro employees.',
            'discount_type' => 'percentage',
            'discount_value' => '25',
            'discount_label' => '25% Tuition Waiver',
            'referral_code' => 'ENGRO-EDU-25',
            'brands' => [$fsBrand->id],
            'courses' => [$course->id],
            'is_active' => '1',
            'is_featured' => '1',
        ]);

        $response->assertRedirect('/admin/mou-partners');
        $this->assertDatabaseHas('mou_partners', [
            'name' => 'Engro Corporation Corporate Benefit',
            'referral_code' => 'ENGRO-EDU-25',
        ]);

        $mou = MouPartner::where('referral_code', 'ENGRO-EDU-25')->first();
        $this->assertNotNull($mou);
        $this->assertTrue($mou->brands->contains($fsBrand));
        $this->assertTrue($mou->courses->contains($course));

        // Reorder test
        $reorderResponse = $this->actingAs($this->admin)->postJson('/admin/mou-partners/reorder', [
            'items' => [
                ['id' => $mou->id, 'sort_order' => 1],
            ],
        ]);
        $reorderResponse->assertOk();
    }
}

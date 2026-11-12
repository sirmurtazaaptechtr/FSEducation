<?php

namespace Tests\Feature;

use App\Models\Banner;
use App\Models\Partner;
use App\Models\Stat;
use App\Models\User;
use App\Services\ImageUploadService;
use App\Services\SettingsService;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;
use Tests\TestCase;

class PhaseTwoArchitectureTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $editor;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);

        $this->admin = User::where('role', 'admin')->first();
        $this->editor = User::where('role', 'editor')->first();
    }

    public function test_admin_can_view_dashboard_with_all_metrics(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/dashboard');

        $response->assertOk();
        $response->assertSee('Network Centres');
        $response->assertSee('Courses & Diplomas', false);
        $response->assertSee('Active MOUs');
    }

    public function test_admin_can_view_and_update_settings_with_cache_refresh(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/settings');
        $response->assertOk();
        $response->assertSee('F.S. Education');

        // Test update
        $updateResponse = $this->actingAs($this->admin)->post('/admin/settings', [
            'company_name' => 'F.S. Education Network Karachi',
            'tagline' => 'Excellence in Vocational & Tech Education',
            'phone' => '+92 21 3498 9999',
            'show_cookie_notice' => '1',
            'show_registration_references' => '1',
            'show_exact_mou_discounts' => '1',
        ]);

        $updateResponse->assertRedirect('/admin/settings');
        $updateResponse->assertSessionHas('success');

        // Ensure database updated
        $this->assertDatabaseHas('settings', [
            'key' => 'company_name',
            'value' => 'F.S. Education Network Karachi',
        ]);

        // Ensure cached helper returns the newly updated value
        $this->assertEquals('F.S. Education Network Karachi', setting('company_name'));
        $this->assertEquals('Excellence in Vocational & Tech Education', setting('tagline'));
    }

    public function test_editor_is_forbidden_from_settings(): void
    {
        $response = $this->actingAs($this->editor)->get('/admin/settings');
        $response->assertStatus(403);

        $postResponse = $this->actingAs($this->editor)->post('/admin/settings', [
            'company_name' => 'Hacked Name',
        ]);
        $postResponse->assertStatus(403);
    }

    public function test_image_upload_service_processes_converts_to_webp_and_generates_thumbnail(): void
    {
        Storage::fake('public');

        $service = app(ImageUploadService::class);
        $file = UploadedFile::fake()->image('test_banner.jpg', 2400, 1200);

        $savedPath = $service->upload(
            file: $file,
            folder: 'banners',
            maxWidth: 1920,
            maxHeight: 800,
            generateThumbnail: true
        );

        // Path should have .webp extension
        $this->assertStringEndsWith('.webp', $savedPath);
        Storage::disk('public')->assertExists($savedPath);

        // Check thumbnail exists
        $thumbPath = 'banners/thumbs/' . basename($savedPath);
        Storage::disk('public')->assertExists($thumbPath);

        // Test delete old file
        $service->delete($savedPath);
        Storage::disk('public')->assertMissing($savedPath);
        Storage::disk('public')->assertMissing($thumbPath);
    }

    public function test_image_upload_service_rejects_invalid_file_types(): void
    {
        Storage::fake('public');
        $service = app(ImageUploadService::class);
        $fakePdf = UploadedFile::fake()->create('document.pdf', 500, 'application/pdf');

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid image format');

        $service->upload($fakePdf, 'banners');
    }

    public function test_banner_crud_and_reorder_endpoint(): void
    {
        Storage::fake('public');

        // 1. Create banner
        $file = UploadedFile::fake()->image('banner_hero.png', 1920, 800);
        $response = $this->actingAs($this->admin)->post('/admin/banners', [
            'title' => 'New Academic Year Enrollment',
            'subtitle' => 'Admissions open across all 5 Karachi campuses',
            'image' => $file,
            'button_text' => 'Apply Online',
            'button_url' => '/contact',
            'is_active' => '1',
            'sort_order' => 10,
        ]);

        $response->assertRedirect('/admin/banners');
        $this->assertDatabaseHas('banners', [
            'title' => 'New Academic Year Enrollment',
        ]);

        $banner = Banner::where('title', 'New Academic Year Enrollment')->first();
        $this->assertNotNull($banner);

        // 2. Reorder endpoint via JSON
        $banner1 = Banner::first();
        $reorderResponse = $this->actingAs($this->admin)->postJson('/admin/banners/reorder', [
            'items' => [
                ['id' => $banner->id, 'sort_order' => 1],
                ['id' => $banner1->id, 'sort_order' => 2],
            ],
        ]);

        $reorderResponse->assertOk();
        $reorderResponse->assertJson(['success' => true]);

        $banner->refresh();
        $this->assertEquals(1, $banner->sort_order);

        // 3. Delete banner
        $deleteResponse = $this->actingAs($this->admin)->delete("/admin/banners/{$banner->id}");
        $deleteResponse->assertRedirect('/admin/banners');
        $this->assertDatabaseMissing('banners', ['id' => $banner->id]);
    }

    public function test_stat_crud_and_reorder(): void
    {
        $createResponse = $this->actingAs($this->admin)->post('/admin/stats', [
            'label' => 'Certified Master Trainers',
            'value' => '150',
            'suffix' => '+',
            'icon' => 'bi-person-badge',
            'is_active' => '1',
        ]);

        $createResponse->assertRedirect('/admin/stats');
        $this->assertDatabaseHas('stats', [
            'label' => 'Certified Master Trainers',
            'value' => '150',
        ]);

        $stat = Stat::where('label', 'Certified Master Trainers')->first();

        // Reorder
        $reorderResponse = $this->actingAs($this->admin)->postJson('/admin/stats/reorder', [
            'items' => [
                ['id' => $stat->id, 'sort_order' => 1],
            ],
        ]);
        $reorderResponse->assertOk();
    }

    public function test_partner_crud_and_reorder(): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('partner_logo.png', 400, 200);

        $createResponse = $this->actingAs($this->admin)->post('/admin/partners', [
            'name' => 'National Technology Council',
            'logo' => $file,
            'url' => 'https://ntc.gov.pk',
            'type' => 'accreditation',
            'is_active' => '1',
        ]);

        $createResponse->assertRedirect('/admin/partners');
        $this->assertDatabaseHas('partners', [
            'name' => 'National Technology Council',
            'type' => 'accreditation',
        ]);
    }
}

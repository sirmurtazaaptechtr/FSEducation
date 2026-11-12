<?php

namespace Tests\Feature;

use App\Models\Affiliation;
use App\Models\Brand;
use App\Models\Centre;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Inquiry;
use App\Models\MouPartner;
use App\Models\Page;
use App\Models\PartnerRequest;
use App\Models\Stat;
use Database\Seeders\AffiliationSeeder;
use Database\Seeders\BrandSeeder;
use Database\Seeders\PageSeeder;
use Database\Seeders\SampleContentSeeder;
use Database\Seeders\SettingSeeder;
use Database\Seeders\StatSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PhaseFourArchitectureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([
            UserSeeder::class,
            BrandSeeder::class,
            AffiliationSeeder::class,
            SettingSeeder::class,
            PageSeeder::class,
            StatSeeder::class,
            SampleContentSeeder::class,
        ]);
    }

    public function test_homepage_renders_all_hierarchy_sections_and_brand_content(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee(setting('company_name', 'F.S. Education'));
        $response->assertSee(setting('tagline', 'Learn Today. Lead Tomorrow.'));
        $response->assertSee('Our Dynamic Network');
        $response->assertSee('Aptech Computer Education');
        $response->assertSee('Arena Multimedia');
        $response->assertSee('Featured Programmes');
        $response->assertSee('Institutional MOU Partnerships');
        $response->assertSee('Official Affiliations');
        $response->assertSee('SBTE');
        $response->assertSee('NAVTTC');
    }

    public function test_group_institutional_pages_render_successfully(): void
    {
        $pages = [
            '/about',
            '/vision-mission',
            '/network',
            '/why-us',
            '/leadership-message',
            '/accreditations',
        ];

        foreach ($pages as $url) {
            $response = $this->get($url);
            $response->assertStatus(200);
        }
    }

    public function test_strict_rule_accreditations_page_only_shows_fs_education_approved_courses(): void
    {
        // Fetch Aptech brand and create an unapproved Aptech course
        $aptech = Brand::where('slug', 'aptech')->first();
        $category = CourseCategory::first();

        $aptechCourse = Course::create([
            'brand_id' => $aptech->id,
            'course_category_id' => $category->id,
            'title' => 'Aptech Advanced Software Development',
            'slug' => 'aptech-advanced-sw',
            'approval_status' => 'approved', // Even if someone sets approved, it is Aptech!
            'is_active' => true,
        ]);

        $response = $this->get('/accreditations');
        $response->assertStatus(200);

        // It must NOT list the Aptech course in the government accredited register
        $response->assertDontSee('Aptech Advanced Software Development');

        // It must see F.S. Education approved diploma
        $response->assertSee('Diploma in Information Technology (DIT)');
    }

    public function test_courses_index_and_filter_queries(): void
    {
        $response = $this->get('/courses');
        $response->assertStatus(200);
        $response->assertSee('Programmes');
        $response->assertSee('Diploma in Information Technology (DIT)');

        // Filter by brand
        $brandResponse = $this->get('/courses?brand=aptech');
        $brandResponse->assertStatus(200);
        $brandResponse->assertSee('Aptech Certified Computer Professional (ACCP Prime)', false);
    }

    public function test_course_detail_shows_correct_approval_and_affiliation_tags(): void
    {
        $ditCourse = Course::where('slug', 'diploma-in-information-technology-dit')->first();
        $response = $this->get('/courses/' . $ditCourse->slug);

        $response->assertStatus(200);
        $response->assertSee('SBTE Affiliated');
        $response->assertSee('Approved Programme');
        $response->assertSee('Institutional Registration & Approval Details', false);

        // Aptech course must NEVER show SBTE or NAVTTC affiliation
        $accpCourse = Course::where('slug', 'aptech-certified-computer-professional-accp-prime')->first();
        $aptechResponse = $this->get('/courses/' . $accpCourse->slug);

        $aptechResponse->assertStatus(200);
        $aptechResponse->assertDontSee('SBTE Affiliated');
        $aptechResponse->assertDontSee('NAVTTC Affiliated');
        $aptechResponse->assertSee('Franchise Certification Track');
    }

    public function test_centre_detail_renders_campus_facilities_and_offered_programmes(): void
    {
        $centre = Centre::where('slug', 'fs-education-main-campus')->first();
        $response = $this->get('/centres/' . $centre->slug);

        $response->assertStatus(200);
        $response->assertSee($centre->name);
        $response->assertSee('Campus Facilities');
        $response->assertSee('Programmes Offered Here');
        $response->assertSee('Inquire at this Campus');
    }

    public function test_mou_partners_index_only_displays_active_partners(): void
    {
        // Create an expired MOU
        $expiredMou = MouPartner::create([
            'name' => 'Expired Partner Organization',
            'slug' => 'expired-partner-org',
            'organization_type' => 'corporate',
            'discount_type' => 'percentage',
            'discount_value' => 15,
            'discount_label' => '15% Off',
            'valid_from' => now()->subMonths(6),
            'valid_until' => now()->subDay(), // Expired yesterday
            'is_active' => true,
        ]);

        $response = $this->get('/mou-partners');
        $response->assertStatus(200);

        // Expired MOU must NOT be displayed
        $response->assertDontSee('Expired Partner Organization');

        // Active seeded MOUs should be visible
        $response->assertSee('Habib Bank Limited');
    }

    public function test_mou_partner_detail_shows_terms_and_referral_code(): void
    {
        $partner = MouPartner::where('slug', 'hbl-corporate-partnership')->first();
        $response = $this->get('/mou-partners/' . $partner->slug);

        $response->assertStatus(200);
        $response->assertSee($partner->name);
        $response->assertSee($partner->discount_label);
        $response->assertSee($partner->referral_code);
        $response->assertSee('How to Avail this Discount');
        $response->assertSee('Claim This Discount');
    }

    public function test_utm_capture_middleware_persists_attribution_in_session(): void
    {
        $this->get('/?utm_source=facebook&utm_medium=cpc&utm_campaign=spring_admission&utm_content=carousel_ad')
            ->assertSessionHas('marketing_utm_data', function ($data) {
                return $data['utm_source'] === 'facebook' &&
                       $data['utm_medium'] === 'cpc' &&
                       $data['utm_campaign'] === 'spring_admission' &&
                       $data['utm_content'] === 'carousel_ad';
            });
    }

    public function test_inquiry_submission_attaches_utm_tracking_data(): void
    {
        // First visit with UTM tracking
        $this->get('/courses?utm_source=instagram&utm_medium=social_bio&utm_campaign=summer_2026');

        $centre = Centre::first();
        $course = Course::first();

        $postData = [
            'name' => 'Kamran Khan',
            'phone' => '0333-9876543',
            'email' => 'kamran@example.com',
            'centre_id' => $centre->id,
            'course_id' => $course->id,
            'message' => 'Interested in weekend batch timings.',
            'website_hp' => '', // Honeypot left empty
        ];

        $response = $this->post('/inquiries', $postData);
        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('inquiries', [
            'name' => 'Kamran Khan',
            'phone' => '0333-9876543',
            'email' => 'kamran@example.com',
            'utm_source' => 'instagram',
            'utm_medium' => 'social_bio',
            'utm_campaign' => 'summer_2026',
            'status' => 'new',
        ]);
    }

    public function test_inquiry_submission_rejected_when_honeypot_filled(): void
    {
        $postData = [
            'name' => 'Spam Bot',
            'phone' => '0000000000',
            'website_hp' => 'http://spam-link.com', // Bot filled honeypot
        ];

        $response = $this->post('/inquiries', $postData);
        $response->assertSessionHasErrors('website_hp');

        $this->assertDatabaseMissing('inquiries', [
            'name' => 'Spam Bot',
        ]);
    }

    public function test_partner_request_submission_with_honeypot_protection(): void
    {
        $validData = [
            'organization_name' => 'Karachi Institute of Technology',
            'contact_person' => 'Dr. Salman Farooq',
            'phone' => '0321-7654321',
            'email' => 'dean@kit.edu.pk',
            'message' => 'We would like to explore an MOU for our computing students.',
            'company_hp' => '',
        ];

        $response = $this->post('/become-a-partner', $validData);
        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('partner_requests', [
            'organization_name' => 'Karachi Institute of Technology',
            'contact_person' => 'Dr. Salman Farooq',
            'email' => 'dean@kit.edu.pk',
            'status' => 'new',
        ]);

        // Test Honeypot rejection
        $spamData = array_merge($validData, ['company_hp' => 'spam bot']);
        $botResponse = $this->post('/become-a-partner', $spamData);
        $botResponse->assertSessionHasErrors('company_hp');
    }

    public function test_open_graph_meta_tags_rendered_on_shareable_pages(): void
    {
        $course = Course::where('slug', 'diploma-in-information-technology-dit')->first();
        $response = $this->get('/courses/' . $course->slug);

        $response->assertStatus(200);
        $response->assertSee('property="og:title"', false);
        $response->assertSee('property="og:description"', false);
        $response->assertSee('property="og:url"', false);
        $response->assertSee('name="twitter:card"', false);
    }
}

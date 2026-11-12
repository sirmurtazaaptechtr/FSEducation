<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            ['group' => 'General', 'key' => 'site_logo', 'value' => null],
            ['group' => 'General', 'key' => 'site_favicon', 'value' => null],
            ['group' => 'General', 'key' => 'aptech_logo', 'value' => null],
            ['group' => 'General', 'key' => 'arena_logo', 'value' => null],
            ['group' => 'General', 'key' => 'company_name', 'value' => 'F.S. Education'],
            ['group' => 'General', 'key' => 'company_legal_name', 'value' => 'F.S. Education Network (Pvt) Ltd'],
            ['group' => 'General', 'key' => 'company_short_name', 'value' => 'FSE'],
            ['group' => 'General', 'key' => 'tagline', 'value' => 'Learn Today. Lead Tomorrow.'],

            // Company Profile
            ['group' => 'Company', 'key' => 'intro', 'value' => 'F.S. Education is a growing educational network committed to empowering individuals through quality education, professional training and industry-relevant skills.'],
            ['group' => 'Company', 'key' => 'vision', 'value' => 'To become a leading educational network that transforms potential into professional success.'],
            ['group' => 'Company', 'key' => 'mission', 'value' => 'To make quality, practical and career-oriented education accessible to aspiring learners.'],
            ['group' => 'Company', 'key' => 'registration_statement', 'value' => 'The network operates through institutions registered with relevant education and skills-development authorities, including SBTE and NAVTTC, subject to the respective centre and approved programme registrations.'],
            ['group' => 'Company', 'key' => 'founder_message', 'value' => 'Education is the greatest catalyst for socio-economic transformation. At F.S. Education, we are committed to bridging the gap between textbook theory and real-world industry demand by delivering rigorous technical, creative and professional career paths.'],

            // Contact
            ['group' => 'Contact', 'key' => 'phone', 'value' => '+92 21 3498 0000'],
            ['group' => 'Contact', 'key' => 'phone_secondary', 'value' => '+92 21 3498 0001'],
            ['group' => 'Contact', 'key' => 'whatsapp', 'value' => '923001234567'],
            ['group' => 'Contact', 'key' => 'email', 'value' => 'info@fseducation.pk'],
            ['group' => 'Contact', 'key' => 'inquiry_notification_email', 'value' => 'admissions@fseducation.pk'],
            ['group' => 'Contact', 'key' => 'address', 'value' => 'Main University Road, Gulshan-e-Iqbal, Block 6, Karachi, Pakistan'],

            // Social
            ['group' => 'Social', 'key' => 'facebook_url', 'value' => 'https://facebook.com/fseducation'],
            ['group' => 'Social', 'key' => 'instagram_url', 'value' => 'https://instagram.com/fseducation'],
            ['group' => 'Social', 'key' => 'linkedin_url', 'value' => 'https://linkedin.com/company/fseducation'],
            ['group' => 'Social', 'key' => 'youtube_url', 'value' => 'https://youtube.com/@fseducation'],
            ['group' => 'Social', 'key' => 'tiktok_url', 'value' => 'https://tiktok.com/@fseducation'],
            ['group' => 'Social', 'key' => 'twitter_url', 'value' => 'https://x.com/fseducation'],

            // SEO Defaults
            ['group' => 'SEO', 'key' => 'meta_title', 'value' => 'F.S. Education | Premier Education & Franchise Network Karachi'],
            ['group' => 'SEO', 'key' => 'meta_description', 'value' => 'F.S. Education is a premier educational group in Karachi running centres under its own brand as well as Aptech and Arena Multimedia franchises with SBTE & NAVTTC affiliations.'],
            ['group' => 'SEO', 'key' => 'meta_keywords', 'value' => 'education Karachi, IT courses, multimedia courses, vocational training, Aptech Karachi, Arena Multimedia Karachi, SBTE diploma, NAVTTC courses'],

            // Marketing
            ['group' => 'Marketing', 'key' => 'meta_pixel_id', 'value' => ''],
            ['group' => 'Marketing', 'key' => 'google_analytics_id', 'value' => ''],
            ['group' => 'Marketing', 'key' => 'default_og_image', 'value' => ''],
            ['group' => 'Marketing', 'key' => 'show_cookie_notice', 'value' => '1'],

            // Display
            ['group' => 'Display', 'key' => 'show_registration_references', 'value' => '1'],
            ['group' => 'Display', 'key' => 'show_exact_mou_discounts', 'value' => '1'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value'], 'group' => $setting['group']]
            );
        }
    }
}

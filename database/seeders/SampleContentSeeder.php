<?php

namespace Database\Seeders;

use App\Models\Affiliation;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Centre;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\MouPartner;
use App\Models\Partner;
use App\Models\Testimonial;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SampleContentSeeder extends Seeder
{
    public function run(): void
    {
        $fsBrand = Brand::where('slug', 'fs-education')->first();
        $aptechBrand = Brand::where('slug', 'aptech')->first();
        $arenaBrand = Brand::where('slug', 'arena-multimedia')->first();

        $sbte = Affiliation::where('short_name', 'SBTE')->first();
        $navttc = Affiliation::where('short_name', 'NAVTTC')->first();

        // 1. Centres
        $centres = [
            [
                'brand_id' => $fsBrand->id,
                'name' => 'F.S. Education Main Technical Campus',
                'slug' => 'fs-education-main-campus',
                'short_description' => 'Flagship vocational and technology training campus housing accredited SBTE & NAVTTC laboratories.',
                'description' => 'Our central campus in Gulshan-e-Iqbal features modern, high-density computing laboratories, a dedicated testing centre for SBTE examinations, and specialized vocational technical labs. Students experience immersive learning guided by certified master trainers.',
                'address' => 'Plot FL-4, Main University Road, Block 6, Gulshan-e-Iqbal, Karachi',
                'area' => 'Gulshan-e-Iqbal',
                'city' => 'Karachi',
                'phone' => '+92 21 3498 1111',
                'whatsapp' => '923001234567',
                'email' => 'maincampus@fseducation.pk',
                'map_url' => 'https://maps.google.com/?q=24.9200,67.0900',
                'registration_note' => 'Centre recognized by Sindh Board of Technical Education (SBTE) for designated technical diplomas.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'brand_id' => $aptechBrand->id,
                'name' => 'Aptech Computer Education - North Nazimabad Centre',
                'slug' => 'aptech-north-nazimabad',
                'short_description' => 'Premier IT education franchise centre in North Nazimabad specializing in software engineering and cloud computing.',
                'description' => 'Operating under the global Aptech franchise framework, the North Nazimabad centre delivers world-class software development, full-stack programming, and database administration tracks aligned with international IT standards.',
                'address' => 'Block H, Main Allama Rasheed Turabi Road, North Nazimabad, Karachi',
                'area' => 'North Nazimabad',
                'city' => 'Karachi',
                'phone' => '+92 21 3664 2222',
                'whatsapp' => '923007654321',
                'email' => 'aptech.nn@fseducation.pk',
                'map_url' => 'https://maps.google.com/?q=24.9350,67.0400',
                'registration_note' => 'Franchise operations adhere strictly to Aptech Worldwide curriculum and quality assurance protocols.',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'brand_id' => $aptechBrand->id,
                'name' => 'Aptech Computer Education - Shahrah-e-Faisal Centre',
                'slug' => 'aptech-shahrah-e-faisal',
                'short_description' => 'Corporate-district IT training campus convenient for working professionals and university students.',
                'description' => 'Situated at the commercial artery of Karachi, the Shahrah-e-Faisal centre caters to evening batches, executive IT programs, and intensive career starter tracks under the Aptech franchise.',
                'address' => 'Suite 302, Business Avenue, Main Shahrah-e-Faisal, PECHS Block 6, Karachi',
                'area' => 'Shahrah-e-Faisal',
                'city' => 'Karachi',
                'phone' => '+92 21 3438 3333',
                'whatsapp' => '923008889999',
                'email' => 'aptech.sef@fseducation.pk',
                'map_url' => 'https://maps.google.com/?q=24.8607,67.0700',
                'registration_note' => 'Authorized Aptech training facility.',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'brand_id' => $arenaBrand->id,
                'name' => 'Arena Multimedia - Clifton Centre',
                'slug' => 'arena-multimedia-clifton',
                'short_description' => 'Karachi’s leading digital arts, VFX, and animation academy in the heart of Clifton.',
                'description' => 'The Clifton centre of Arena Multimedia offers high-end graphic workstations, green screen video production facilities, and audio studios designed for aspiring 3D animators, film editors, and game artists.',
                'address' => 'Clifton Centre, 4th Floor, Marine Drive, Block 5, Clifton, Karachi',
                'area' => 'Clifton',
                'city' => 'Karachi',
                'phone' => '+92 21 3587 4444',
                'whatsapp' => '923005556666',
                'email' => 'arena.clifton@fseducation.pk',
                'map_url' => 'https://maps.google.com/?q=24.8200,67.0300',
                'registration_note' => 'Authorized Arena Multimedia creative production academy.',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'brand_id' => $arenaBrand->id,
                'name' => 'Arena Multimedia - Gulshan Centre',
                'slug' => 'arena-multimedia-gulshan',
                'short_description' => 'Vibrant multimedia creative centre delivering animation, UI/UX, and architectural visualization diplomas.',
                'description' => 'Conveniently situated in Gulshan-e-Iqbal, this Arena centre empowers creative students with industry-grade software training in Maya, Blender, Adobe Creative Cloud, and Unreal Engine.',
                'address' => 'Plot C-12, Block 13-A, Gulshan-e-Iqbal, Main Rashid Minhas Road, Karachi',
                'area' => 'Gulshan-e-Iqbal',
                'city' => 'Karachi',
                'phone' => '+92 21 3481 5555',
                'whatsapp' => '923004443333',
                'email' => 'arena.gulshan@fseducation.pk',
                'map_url' => 'https://maps.google.com/?q=24.9150,67.1050',
                'registration_note' => 'Authorized Arena Multimedia design institute.',
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        $createdCentres = [];
        foreach ($centres as $data) {
            $centre = Centre::updateOrCreate(['slug' => $data['slug']], $data);
            $createdCentres[$data['slug']] = $centre;

            // Seed sample facility image for each centre
            \App\Models\CentreImage::updateOrCreate(
                ['centre_id' => $centre->id, 'caption' => 'High-Density Computing Laboratory'],
                [
                    'path' => 'centres/sample-lab.webp',
                    'alt_text' => $centre->name . ' Computing Lab',
                    'sort_order' => 1,
                ]
            );
        }

        // 2. Course Categories
        $categories = [
            ['name' => 'Software & Web Development', 'slug' => 'software-web-development', 'sort_order' => 1],
            ['name' => 'Animation & Multimedia Design', 'slug' => 'animation-multimedia-design', 'sort_order' => 2],
            ['name' => 'Technical & Government Diplomas', 'slug' => 'technical-government-diplomas', 'sort_order' => 3],
            ['name' => 'Emerging Technologies & AI', 'slug' => 'emerging-technologies-ai', 'sort_order' => 4],
        ];

        $createdCategories = [];
        foreach ($categories as $cat) {
            $createdCategories[$cat['slug']] = CourseCategory::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        // 3. Courses
        $courses = [
            // F.S. Education approved SBTE course
            [
                'brand_id' => $fsBrand->id,
                'course_category_id' => $createdCategories['technical-government-diplomas']->id,
                'affiliation_id' => $sbte ? $sbte->id : null,
                'title' => 'Diploma in Information Technology (DIT)',
                'slug' => 'diploma-in-information-technology-dit',
                'short_description' => 'One-year recognized technical diploma accredited and certified by the Sindh Board of Technical Education (SBTE).',
                'description' => 'The DIT programme is a comprehensive one-year government-recognized curriculum designed to equip learners with solid fundamentals in computer hardware, office applications, database management, web design, and programming logic. Ideal for students seeking public or private sector employment qualifications.',
                'duration' => '1 Year (2 Semesters)',
                'eligibility' => 'Matriculation (Science or Arts) or equivalent from a recognized board',
                'fee_note' => 'Affordable monthly installment plan available. Board examination fees separate.',
                'outcomes' => "• Official SBTE Board Diploma certificate upon passing examinations\n• Proficiency in Python programming and relational databases\n• Practical skills in responsive web design and office automation\n• Eligibility for public sector IT technician positions",
                'approval_status' => 'approved',
                'registration_reference' => 'SBTE/AFF/2023-914',
                'approval_note' => 'Officially approved and examined under Sindh Board of Technical Education statutes.',
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 1,
                'centres' => ['fs-education-main-campus'],
            ],
            // F.S. Education approved NAVTTC course
            [
                'brand_id' => $fsBrand->id,
                'course_category_id' => $createdCategories['technical-government-diplomas']->id,
                'affiliation_id' => $navttc ? $navttc->id : null,
                'title' => 'Certified Cloud & DevOps Specialist',
                'slug' => 'certified-cloud-devops-specialist',
                'short_description' => 'High-impact 6-month specialized professional course under NAVTTC national vocational competency standards.',
                'description' => 'Designed in partnership with national vocational standards, this programme delivers deep practical immersion in AWS Cloud Architecture, Docker containers, Kubernetes cluster management, CI/CD pipelines, and Linux system administration.',
                'duration' => '6 Months (24 Weeks)',
                'eligibility' => 'Intermediate / F.Sc / DAE or basic IT background recommended',
                'fee_note' => 'Subsidized fee structure under national skills initiatives.',
                'outcomes' => "• National NAVTTC certificate of competency\n• Hands-on mastery of AWS services, Terraform, Docker, and Kubernetes\n• Portfolio of live automated cloud deployments\n• Direct referral to hiring software houses",
                'approval_status' => 'approved',
                'registration_reference' => 'NAVTTC/PRG/KHI-2024-55',
                'approval_note' => 'Approved under National Vocational and Technical Training Commission framework.',
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 2,
                'centres' => ['fs-education-main-campus'],
            ],
            // F.S. Education own non-affiliated short course
            [
                'brand_id' => $fsBrand->id,
                'course_category_id' => $createdCategories['software-web-development']->id,
                'affiliation_id' => null,
                'title' => 'Full-Stack Web Engineering with Laravel & React',
                'slug' => 'full-stack-web-engineering-laravel-react',
                'short_description' => 'Modern industry-ready boot camp taking students from HTML/CSS to robust enterprise web apps.',
                'description' => 'An intensive hands-on development boot camp covering modern backend development with PHP/Laravel, RESTful APIs, MySQL, and dynamic frontend development with React.',
                'duration' => '4 Months',
                'eligibility' => 'Basic computer literacy and enthusiasm to write code',
                'fee_note' => 'Scholarships available based on aptitude test.',
                'outcomes' => "• 4 portfolio web applications hosted live\n• Solid grasp of MVC architecture, Git workflows, and API security\n• F.S. Education Certificate of Completion",
                'approval_status' => 'none',
                'registration_reference' => null,
                'approval_note' => null,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 3,
                'centres' => ['fs-education-main-campus'],
            ],
            // Aptech course 1
            [
                'brand_id' => $aptechBrand->id,
                'course_category_id' => $createdCategories['software-web-development']->id,
                'affiliation_id' => null, // Strict franchisor rule: must be null
                'title' => 'Aptech Certified Computer Professional (ACCP Prime)',
                'slug' => 'aptech-certified-computer-professional-accp-prime',
                'short_description' => 'Flagship 3-year career program in software engineering, enterprise cloud solutions, and full-stack development.',
                'description' => 'ACCP Prime is Aptech’s renowned multi-term career programme designed to turn school/college graduates into complete software engineers with skills spanning Java Enterprise, Microsoft .NET, Python, and cloud architectures.',
                'duration' => '3 Years (6 Terms)',
                'eligibility' => 'Matriculation or Intermediate with a passion for software careers',
                'fee_note' => 'Semester-based installment plan.',
                'outcomes' => "• Globally recognized Aptech certification\n• Advanced proficiency in Java, C#, Python, and SQL\n• Capstone enterprise application development\n• Credit transfer opportunities to partner international universities",
                'approval_status' => 'none',
                'registration_reference' => null,
                'approval_note' => null,
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 4,
                'centres' => ['aptech-north-nazimabad', 'aptech-shahrah-e-faisal'],
            ],
            // Aptech course 2
            [
                'brand_id' => $aptechBrand->id,
                'course_category_id' => $createdCategories['emerging-technologies-ai']->id,
                'affiliation_id' => null, // Strict franchisor rule: must be null
                'title' => 'Smart Pro: Artificial Intelligence & Machine Learning',
                'slug' => 'smart-pro-artificial-intelligence-machine-learning',
                'short_description' => 'Cutting-edge modular program focusing on Python, data science libraries, deep learning, and generative AI models.',
                'description' => 'Prepare for the future of tech with Aptech’s Smart Pro track in AI & Machine Learning. Master NumPy, Pandas, Scikit-Learn, TensorFlow, and natural language processing techniques.',
                'duration' => '9 Months',
                'eligibility' => 'Intermediate with mathematics or computer science background',
                'fee_note' => 'Installments available.',
                'outcomes' => "• Aptech Smart Pro International Certificate\n• End-to-end predictive modeling and machine learning projects\n• Generative AI and prompt engineering foundations",
                'approval_status' => 'none',
                'registration_reference' => null,
                'approval_note' => null,
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 5,
                'centres' => ['aptech-north-nazimabad', 'aptech-shahrah-e-faisal'],
            ],
            // Arena Multimedia course 1
            [
                'brand_id' => $arenaBrand->id,
                'course_category_id' => $createdCategories['animation-multimedia-design']->id,
                'affiliation_id' => null, // Strict franchisor rule: must be null
                'title' => 'Arena Multimedia Specialist Program (AMSP)',
                'slug' => 'arena-multimedia-specialist-program-amsp',
                'short_description' => 'Comprehensive 2-year creative diploma in 2D design, UI/UX, 3D modeling, animation, and digital filmmaking.',
                'description' => 'AMSP is the premier creative industry credential for students who aspire to careers in film visual effects, television commercials, gaming studios, and digital brand design.',
                'duration' => '2 Years (4 Semesters)',
                'eligibility' => 'Intermediate or Matriculation with visual aptitude',
                'fee_note' => 'Monthly installment options available.',
                'outcomes' => "• Arena Multimedia Specialist Diploma\n• Professional student showreel across 2D/3D and motion design\n• Master software: Adobe Suite, Autodesk Maya, Blender, Premiere, After Effects\n• Placement assistance at leading media agencies",
                'approval_status' => 'none',
                'registration_reference' => null,
                'approval_note' => null,
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 6,
                'centres' => ['arena-multimedia-clifton', 'arena-multimedia-gulshan'],
            ],
            // Arena Multimedia course 2
            [
                'brand_id' => $arenaBrand->id,
                'course_category_id' => $createdCategories['animation-multimedia-design']->id,
                'affiliation_id' => null, // Strict franchisor rule: must be null
                'title' => 'Visual Effects & Compositing Pro (VFX Pro)',
                'slug' => 'visual-effects-compositing-pro-vfx-pro',
                'short_description' => 'Specialized advanced track covering live-action matchmoving, rotoscoping, particle simulations, and Nuke compositing.',
                'description' => 'An advanced studio-grade program designed for aspiring VFX artists. Students train in industry-standard tools including Foundry Nuke, Houdini dynamics, and live action chroma shooting.',
                'duration' => '1 Year',
                'eligibility' => 'Prior graphics experience or Arena foundation certificate',
                'fee_note' => 'Installments available.',
                'outcomes' => "• Production-ready VFX reel with realistic live-action integration\n• Arena VFX Master Certificate\n• Specialized employment preparation for studio roles",
                'approval_status' => 'none',
                'registration_reference' => null,
                'approval_note' => null,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 7,
                'centres' => ['arena-multimedia-clifton', 'arena-multimedia-gulshan'],
            ],
        ];

        $createdCourses = [];
        foreach ($courses as $cData) {
            $centreSlugs = $cData['centres'];
            unset($cData['centres']);

            $course = Course::updateOrCreate(['slug' => $cData['slug']], $cData);
            $createdCourses[$course->slug] = $course;

            // Attach to centres
            $centreIds = [];
            foreach ($centreSlugs as $cSlug) {
                if (isset($createdCentres[$cSlug])) {
                    $centreIds[] = $createdCentres[$cSlug]->id;
                }
            }
            $course->centres()->sync($centreIds);
        }

        // 4. MOU Partners
        $today = Carbon::today();

        $mouPartners = [
            [
                'name' => 'Habib Bank Limited (HBL Staff & Families)',
                'slug' => 'hbl-corporate-partnership',
                'organization_type' => 'corporate',
                'short_description' => 'Special educational benefit MOU offering tuition subsidies for HBL staff, spouses, and children.',
                'description' => 'Through a signed memorandum of understanding between F.S. Education and Habib Bank Limited, verified permanent and contractual employees of HBL and their direct family members are entitled to tuition fee waivers on approved F.S. Education programmes.',
                'website_url' => 'https://www.hbl.com',
                'signed_on' => $today->copy()->subMonths(6),
                'valid_from' => $today->copy()->subMonths(6),
                'valid_until' => $today->copy()->addMonths(18), // Active
                'discount_type' => 'percentage',
                'discount_value' => '20',
                'discount_label' => '20% Tuition Fee Waiver',
                'terms' => "1. Valid for full-time and diploma courses at F.S. Education.\n2. Must present valid HBL employee badge and HR referral letter at time of admission.\n3. Applicable on tuition fee only (examination and admission processing fees excluded).",
                'how_to_avail' => "Step 1: Obtain a discount voucher or HR letter from your HBL branch/HR.\nStep 2: Submit an admission inquiry online with code HBL-EDU-20.\nStep 3: Present your original credentials at the admission office to verify your fee waiver.",
                'referral_code' => 'HBL-EDU-20',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 1,
                'brands' => [$fsBrand->id],
            ],
            [
                'name' => 'Karachi Grammar School Alumni Network',
                'slug' => 'kgs-alumni-network',
                'organization_type' => 'school',
                'short_description' => 'Tuition grant agreement for KGS alumni and graduating students taking tech or design diplomas.',
                'description' => 'F.S. Education is proud to partner with the KGS Alumni Association to provide young graduates with practical tech bootcamps and vocational credentials at subsidized tuition rates.',
                'website_url' => 'https://www.kgs.edu.pk',
                'signed_on' => $today->copy()->subMonths(3),
                'valid_from' => $today->copy()->subMonths(3),
                'valid_until' => $today->copy()->addMonths(9), // Active
                'discount_type' => 'percentage',
                'discount_value' => '15',
                'discount_label' => '15% Student Discount',
                'terms' => 'Valid upon presentation of alumni card or recent graduation verification letter.',
                'how_to_avail' => 'Enter your alumni member ID during online inquiry and bring verification to the campus.',
                'referral_code' => 'KGS-PARTNER-15',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 2,
                'brands' => [$fsBrand->id],
            ],
            [
                'name' => 'NED University Engineering Students Council',
                'slug' => 'ned-university-partnership',
                'organization_type' => 'university',
                'short_description' => 'Skill enhancement MOU granting subsidized enrollment in Cloud, DevOps, and AI boot camps.',
                'description' => 'Formal agreement facilitating engineering undergraduates from NED University of Engineering & Technology to upskill in emerging technologies alongside their degree.',
                'website_url' => 'https://www.neduet.edu.pk',
                'signed_on' => $today->copy()->subMonths(4),
                'valid_from' => $today->copy()->subMonths(4),
                'valid_until' => $today->copy()->addMonths(14), // Active
                'discount_type' => 'percentage',
                'discount_value' => '25',
                'discount_label' => '25% Student Grant',
                'terms' => 'Open to all currently enrolled NED students with valid university ID card.',
                'how_to_avail' => 'Use promo code NED-TECH-25 on the admission form.',
                'referral_code' => 'NED-TECH-25',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 3,
                'brands' => [$fsBrand->id],
            ],
            [
                'name' => 'Rotary Club of Karachi Community Welfare',
                'slug' => 'rotary-club-community-welfare',
                'organization_type' => 'ngo',
                'short_description' => 'Fixed vocational scholarship grant for sponsored underprivileged youth.',
                'description' => 'Corporate social responsibility initiative providing PKR 10,000 fixed fee reductions per diploma candidate nominated by Rotary Club Karachi.',
                'website_url' => 'https://rotary.org',
                'signed_on' => $today->copy()->subMonths(2),
                'valid_from' => $today->copy()->subMonths(2),
                'valid_until' => $today->copy()->addMonths(10), // Active
                'discount_type' => 'fixed',
                'discount_value' => '10000',
                'discount_label' => 'PKR 10,000 Special Grant',
                'terms' => 'Candidate must be formally nominated by an authorized Rotary Club Karachi official.',
                'how_to_avail' => 'Submit candidate referral letter from Rotary Club Karachi East during registration.',
                'referral_code' => 'ROTARY-GRANT-10K',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 4,
                'brands' => [$fsBrand->id],
            ],
            // Scheduled MOU (starts next year - tests date filter)
            [
                'name' => 'Pakistan Software Houses Association (P@SHA)',
                'slug' => 'pasha-skills-future-mou',
                'organization_type' => 'association',
                'short_description' => 'Upcoming IT apprenticeship and training subsidy agreement scheduled for future roll-out.',
                'description' => 'Strategic partnership scheduled to activate in upcoming academic sessions for member tech enterprises.',
                'website_url' => 'https://pasha.org.pk',
                'signed_on' => $today->copy()->addDays(5),
                'valid_from' => $today->copy()->addMonths(2), // Future date
                'valid_until' => $today->copy()->addMonths(14),
                'discount_type' => 'percentage',
                'discount_value' => '30',
                'discount_label' => '30% Tech Industry Grant',
                'terms' => 'Scheduled for future activation.',
                'how_to_avail' => 'Details will be announced upon official programme launch.',
                'referral_code' => 'PASHA-FUTURE',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 5,
                'brands' => [], // Empty by default
            ],
            // Expired MOU (ended in the past - tests date filter)
            [
                'name' => 'Legacy Karachi Retailers Association',
                'slug' => 'legacy-retailers-association',
                'organization_type' => 'association',
                'short_description' => 'Past promotional training MOU for retail office personnel.',
                'description' => 'Past promotional training campaign which concluded last academic year.',
                'website_url' => null,
                'signed_on' => $today->copy()->subMonths(18),
                'valid_from' => $today->copy()->subMonths(18),
                'valid_until' => $today->copy()->subMonths(3), // Past date
                'discount_type' => 'percentage',
                'discount_value' => '10',
                'discount_label' => '10% Past Discount',
                'terms' => 'This agreement has expired.',
                'how_to_avail' => 'No longer available.',
                'referral_code' => 'RETAIL-EXPIRED',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 6,
                'brands' => [$fsBrand->id],
            ],
        ];

        foreach ($mouPartners as $partnerData) {
            $brandIds = $partnerData['brands'];
            unset($partnerData['brands']);

            $mou = MouPartner::updateOrCreate(['slug' => $partnerData['slug']], $partnerData);
            $mou->brands()->sync($brandIds);
        }

        // 5. Banners
        $banners = [
            [
                'title' => 'Empowering Careers Through Quality Education & Real Skills',
                'subtitle' => 'Join Karachi’s leading network of technical, IT and multimedia campuses affiliated with SBTE, NAVTTC, and global franchise partners.',
                'image' => 'banners/banner-1.webp',
                'button_text' => 'Explore Programmes',
                'button_url' => '/courses',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Avail Exclusive MOU Tuition Discounts',
                'subtitle' => 'Employees, students, and associates of our partner organizations receive agreed scholarship grants of up to 25%.',
                'image' => 'banners/banner-2.webp',
                'button_text' => 'View MOU Partners',
                'button_url' => '/mou-partners',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Our 5 Campus Network Across Karachi',
                'subtitle' => 'High-tech computer labs and master trainers in Gulshan, North Nazimabad, Clifton, and Shahrah-e-Faisal.',
                'image' => 'banners/banner-3.webp',
                'button_text' => 'Locate a Centre',
                'button_url' => '/centres',
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($banners as $b) {
            Banner::updateOrCreate(['title' => $b['title']], $b);
        }

        // 6. Testimonials
        $testimonials = [
            [
                'name' => 'Syed Bilal Ahmed',
                'role_or_course' => 'DIT Alumnus • Software Developer at Systems Ltd',
                'quote' => 'The hands-on lab training at F.S. Education gave me practical skills that allowed me to transition immediately into a junior software engineering role. The SBTE accreditation gave my credentials immediate credibility.',
                'photo' => null,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Ayesha Siddiqui',
                'role_or_course' => 'AMSP Alumna • 3D Character Animator',
                'quote' => 'Arena Multimedia Clifton transformed my creative hobbies into a real career. The faculty mentorship on my animation showreel helped me secure a position at a major advertising studio in Karachi.',
                'photo' => null,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Muhammad Danial',
                'role_or_course' => 'ACCP Graduate • Cloud Support Specialist',
                'quote' => 'Studying under the Aptech franchise at Shahrah-e-Faisal was the best decision for my career. The structured curriculum and project-oriented exams prepared me for real enterprise software development.',
                'photo' => null,
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($testimonials as $t) {
            Testimonial::updateOrCreate(['name' => $t['name']], $t);
        }

        // 7. General Partners
        $partners = [
            [
                'name' => 'Sindh Board of Technical Education',
                'logo' => 'partners/sbte-logo.webp',
                'url' => 'https://www.sbte.edu.pk',
                'type' => 'affiliation',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'National Vocational and Technical Training Commission',
                'logo' => 'partners/navttc-logo.webp',
                'url' => 'https://www.navttc.gov.pk',
                'type' => 'affiliation',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Habib Bank Limited',
                'logo' => 'partners/hbl-logo.webp',
                'url' => 'https://www.hbl.com',
                'type' => 'partner',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Pakistan Software Houses Association',
                'logo' => 'partners/pasha-logo.webp',
                'url' => 'https://pasha.org.pk',
                'type' => 'partner',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($partners as $p) {
            Partner::updateOrCreate(['name' => $p['name']], $p);
        }
    }
}


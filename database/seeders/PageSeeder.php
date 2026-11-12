<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'slug' => 'about',
                'title' => 'About F.S. Education Group',
                'meta_title' => 'About F.S. Education | Karachi Educational Network',
                'meta_description' => 'Learn about the history, vision, and educational leadership of F.S. Education and its network of technology and creative institutions across Karachi.',
                'body' => '<p class="lead">F.S. Education is a forward-thinking educational network founded to deliver high-calibre technical, vocational, and creative multimedia education to students and aspiring professionals across Karachi.</p>
                <p>Operating a dynamic portfolio comprising its own proprietary programmes alongside world-renowned franchises such as Aptech and Arena Multimedia, the group provides industry-aligned learning environments supported by state-of-the-art computer labs, certified master trainers, and modern pedagogy.</p>
                <h3>Our Foundational Pillars</h3>
                <ul>
                    <li><strong>Rigorous Academic Standards:</strong> Curriculum designed to reflect real workplace demands and international benchmarks.</li>
                    <li><strong>Practical Hands-On Immersion:</strong> Project-driven learning where students build working portfolios before graduation.</li>
                    <li><strong>Institutional Credibility:</strong> Clear, verifiable programme registrations with regulatory bodies including SBTE and NAVTTC.</li>
                    <li><strong>Strong Corporate Synergies:</strong> Active MOU partnerships delivering valuable tuition subsidies to students from affiliated entities.</li>
                </ul>',
            ],
            [
                'slug' => 'vision-mission',
                'title' => 'Vision & Mission',
                'meta_title' => 'Our Vision & Mission | F.S. Education Group',
                'meta_description' => 'Our vision to transform potential into professional success and our mission to provide accessible, career-oriented education.',
                'body' => '<div class="row g-4 my-3">
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm p-4 bg-light">
                            <h3 class="text-primary"><i class="bi bi-eye me-2"></i> Our Vision</h3>
                            <p class="fs-5">"To become a leading educational network that transforms potential into professional success."</p>
                            <p class="text-muted">We envision a future where every learner who walks through our doors is equipped with relevant, globally competitive skills that unlock sustainable career advancement.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm p-4 bg-light">
                            <h3 class="text-primary"><i class="bi bi-compass me-2"></i> Our Mission</h3>
                            <p class="fs-5">"To make quality, practical and career-oriented education accessible to aspiring learners."</p>
                            <p class="text-muted">We deliver on this mission through an interconnected network of state-of-the-art centres, modern pedagogical models, accredited vocational curricula, and strategic community partnerships.</p>
                        </div>
                    </div>
                </div>',
            ],
            [
                'slug' => 'network',
                'title' => 'Our Educational Network',
                'meta_title' => 'Our Five Centres Network in Karachi | F.S. Education',
                'meta_description' => 'Explore the five specialised education centres operating across Karachi under the F.S. Education parent brand and premier franchise partners.',
                'body' => '<p class="lead">F.S. Education operates five strategic campuses across Karachi, ensuring students in all major districts have accessible, high-speed access to modern tech and design education.</p>
                <p>Each centre in our network is operated with dedicated faculty, modern computing laboratories, and dedicated placement cells to guide learners into the workforce.</p>',
            ],
            [
                'slug' => 'why-us',
                'title' => 'Why Choose F.S. Education?',
                'meta_title' => 'Why Choose F.S. Education | Proven Career Outcomes',
                'meta_description' => 'Discover what makes F.S. Education different: certified faculty, hands-on labs, industry affiliations, and guaranteed student discounts through partner MOUs.',
                'body' => '<h3>Empowering Learners with Real-World Value</h3>
                <p>In a competitive job landscape, credentials must be backed by practical ability. F.S. Education blends verified statutory recognitions with globally recognized franchise curricula to offer an unmatched learning experience.</p>
                <div class="row g-4 mt-2">
                    <div class="col-md-4">
                        <h5>Certified Master Instructors</h5>
                        <p class="text-muted">Our instructors are active industry practitioners and certified trainers with deep field experience.</p>
                    </div>
                    <div class="col-md-4">
                        <h5>Accredited Programmes</h5>
                        <p class="text-muted">Select F.S. Education courses carry formal registration and certification from SBTE and NAVTTC.</p>
                    </div>
                    <div class="col-md-4">
                        <h5>MOU Tuition Subsidies</h5>
                        <p class="text-muted">Through institutional MOUs with corporations and educational institutes, our students access exclusive financial discounts.</p>
                    </div>
                </div>',
            ],
            [
                'slug' => 'accreditations',
                'title' => 'Accreditations & Affiliations',
                'meta_title' => 'Accreditations & Government Affiliations | F.S. Education',
                'meta_description' => 'Learn how F.S. Education delivers programmes registered with SBTE (Sindh Board of Technical Education) and NAVTTC (National Vocational & Technical Training Commission).',
                'body' => '<p class="lead">Institutional legitimacy and regulatory transparency are core tenets of F.S. Education. The group maintains formal registrations with Pakistan’s primary vocational and technical governing bodies for designated programmes.</p>
                <div class="alert alert-info">
                    <strong>Important Note on Network Operations:</strong> Registration and statutory approval claims apply strictly to individual centres and specific approved programmes. They do not constitute an indiscriminate blanket claim across all network offerings or franchise brands.
                </div>',
            ],
            [
                'slug' => 'leadership-message',
                'title' => 'Message from Leadership',
                'meta_title' => 'Message from Leadership | F.S. Education Network',
                'meta_description' => 'A message from the leadership of F.S. Education on our ongoing commitment to youth empowerment and market-ready skills in Karachi.',
                'body' => '<blockquote>
                    <p class="fs-5 italic">"Education is not merely about receiving a certificate; it is about building the capability, character, and agility to thrive in a digital economy."</p>
                </blockquote>
                <p>Welcome to F.S. Education. As founder and managing director, I have witnessed first-hand how targeted, hands-on vocational and multimedia training can alter the trajectory of a young person’s career.</p>
                <p>Whether you choose an accredited government diploma under F.S. Education or enter an international franchise track through Aptech or Arena Multimedia, our team is committed to your complete professional development.</p>',
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(['slug' => $page['slug']], $page);
        }
    }
}

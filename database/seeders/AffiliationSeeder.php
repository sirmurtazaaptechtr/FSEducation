<?php

namespace Database\Seeders;

use App\Models\Affiliation;
use Illuminate\Database\Seeder;

class AffiliationSeeder extends Seeder
{
    public function run(): void
    {
        $affiliations = [
            [
                'name' => 'Sindh Board of Technical Education',
                'short_name' => 'SBTE',
                'website_url' => 'https://www.sbte.edu.pk',
                'description' => 'Statutory examining and certifying authority established by the Government of Sindh for technical and commercial education.',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'National Vocational and Technical Training Commission',
                'short_name' => 'NAVTTC',
                'website_url' => 'https://www.navttc.gov.pk',
                'description' => 'Apex national regulatory body for technical vocational education and training policy, standards, and accreditation under the Government of Pakistan.',
                'sort_order' => 2,
                'is_active' => true,
            ],
        ];

        foreach ($affiliations as $affiliation) {
            Affiliation::updateOrCreate(['short_name' => $affiliation['short_name']], $affiliation);
        }
    }
}

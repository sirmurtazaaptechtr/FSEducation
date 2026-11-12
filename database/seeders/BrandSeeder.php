<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            [
                'name' => 'F.S. Education',
                'slug' => 'fs-education',
                'description' => 'The parent education network committed to empowering individuals through quality education, professional training, and industry-relevant skills.',
                'logo' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Aptech',
                'slug' => 'aptech',
                'description' => 'A global pioneer in Information Technology education and career transformation, operating under franchise agreements.',
                'logo' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Arena Multimedia',
                'slug' => 'arena-multimedia',
                'description' => 'A premier creative media and design franchise institution specializing in 2D/3D animation, VFX, graphic design, and UI/UX.',
                'logo' => null,
                'is_active' => true,
            ],
        ];

        foreach ($brands as $brand) {
            Brand::updateOrCreate(['slug' => $brand['slug']], $brand);
        }
    }
}


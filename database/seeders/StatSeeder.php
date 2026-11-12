<?php

namespace Database\Seeders;

use App\Models\Stat;
use Illuminate\Database\Seeder;

class StatSeeder extends Seeder
{
    public function run(): void
    {
        $stats = [
            [
                'label' => 'Students Trained',
                'value' => '25,000',
                'suffix' => '+',
                'icon' => 'bi-mortarboard-fill',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'label' => 'Active Network Centres',
                'value' => '5',
                'suffix' => '',
                'icon' => 'bi-building-fill-check',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'label' => 'Career Placement Rate',
                'value' => '92',
                'suffix' => '%',
                'icon' => 'bi-graph-up-arrow',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'label' => 'Active Partner MOUs',
                'value' => '40',
                'suffix' => '+',
                'icon' => 'bi-handshake-fill',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($stats as $stat) {
            Stat::updateOrCreate(['label' => $stat['label']], $stat);
        }
    }
}


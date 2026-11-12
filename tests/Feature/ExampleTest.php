<?php

namespace Tests\Feature;

use Database\Seeders\AffiliationSeeder;
use Database\Seeders\BrandSeeder;
use Database\Seeders\PageSeeder;
use Database\Seeders\SampleContentSeeder;
use Database\Seeders\SettingSeeder;
use Database\Seeders\StatSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $this->seed([
            UserSeeder::class,
            BrandSeeder::class,
            AffiliationSeeder::class,
            SettingSeeder::class,
            PageSeeder::class,
            StatSeeder::class,
            SampleContentSeeder::class,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}

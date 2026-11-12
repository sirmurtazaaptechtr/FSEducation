<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminEmail = env('ADMIN_EMAIL', 'admin@fseducation.pk');
        $adminName = env('ADMIN_NAME', 'F.S. Education Admin');
        $adminPassword = env('ADMIN_PASSWORD', 'AdminPassword2026!');

        User::updateOrCreate(
            ['email' => $adminEmail],
            [
                'name' => $adminName,
                'password' => Hash::make($adminPassword),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        // Editor user for role testing
        User::updateOrCreate(
            ['email' => 'editor@fseducation.pk'],
            [
                'name' => 'F.S. Education Content Editor',
                'password' => Hash::make('EditorPassword2026!'),
                'role' => 'editor',
                'is_active' => true,
            ]
        );
    }
}

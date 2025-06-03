<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user if not exists
        User::firstOrCreate(
            ['email' => 'admin@spkjamu.com'],
            [
                'name' => 'Super Admin',
                'email' => 'admin@spkjamu.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // Create regular user for testing
        User::firstOrCreate(
            ['email' => 'user@spkjamu.com'],
            [
                'name' => 'Regular User',
                'email' => 'user@spkjamu.com',
                'password' => Hash::make('user123'),
                'role' => 'user',
            ]
        );
    }
}

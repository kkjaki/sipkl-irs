<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'), // Consider using Hash::make() for better security
            'email_verified_at' => now(),
            'role' => 'admin',
            'status' => 'active',
        ]);

        User::create([
            'name' => 'Owner User',
            'email' => 'owner@example.com',
            'password' => bcrypt('password'), // Consider using Hash::make() for better security
            'email_verified_at' => now(),
            'role' => 'owner',
            'status' => 'active',
        ]);
    }
}

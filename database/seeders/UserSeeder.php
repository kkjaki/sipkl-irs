<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            'password' => Hash::make('12345678'), // Consider using Hash::make() for better security
            'email_verified_at' => now(),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Owner User',
            'email' => 'owner@example.com',
            'password' => Hash::make('12345678'), // Consider using Hash::make() for better security
            'email_verified_at' => now(),
            'role' => 'owner',
        ]);
    }
}

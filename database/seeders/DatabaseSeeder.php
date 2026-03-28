<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Industry;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Bikin Akun Owner (Way)
        $owner = User::create([
            'name' => 'Way',
            'email' => 'way@irs.com',
            'password' => Hash::make('password123'),
            'role' => 'owner', 
        ]);

        // 2. Bikin Data Perusahaannya (PT Internet Rakyat Sejahtera)
        Industry::create([
            'owner_id' => $owner->id,
            'name' => 'PT Internet Rakyat Sejahtera',
        ]);
    }
}
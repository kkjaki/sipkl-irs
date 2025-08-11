<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call the UserSeeder to seed the users table
        $this->call(UserSeeder::class);
        // Call the IndustrySeeder to seed the industries table
        $this->call(IndustrySeeder::class);

        // You can also call other seeders here if needed
        // $this->call(OtherSeeder::class);
    }
}

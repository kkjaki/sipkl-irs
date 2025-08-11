<?php

namespace Database\Seeders;

use App\Models\Industry;
use Illuminate\Database\Seeder;

class IndustrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Industry::create([
            'id' => 1,
            'owner_id' => 2, // Assuming the owner ID is 2
            'name' => 'PT. Education',
            'address' => '123 Education St, Knowledge City',
            'phone' => '123-456-7890',
        ]);
        // Add more industries as needed
    }
}

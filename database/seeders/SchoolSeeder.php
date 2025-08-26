<?php

namespace Database\Seeders;

use App\Models\Industry;
use App\Models\School;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $industries = Industry::all();

        if ($industries->isEmpty()) {
            $this->command->info('No industries found. Please run the IndustrySeeder first.');
            return;
        }

        foreach ($industries as $industry) {
            School::factory()->count(3)->create([
                'industry_id' => $industry->id,
            ]);
        }
    }
}

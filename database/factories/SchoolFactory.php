<?php

namespace Database\Factories;

use App\Models\Industry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\School>
 */
class SchoolFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'industry_id' => Industry::factory(),
            'name' => $this->faker->company . ' High School',
            'address' => $this->faker->address,
            'phone' => $this->faker->numerify('##########'),
        ];
    }
}

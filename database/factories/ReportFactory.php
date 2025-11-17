<?php

namespace Database\Factories;

use App\Enum\ReportStatus;
use App\Models\Member;
use App\Models\Operator;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'member_id' => Member::inRandomOrder()->value('id'),
            'operator_id' => Operator::inRandomOrder()->value('id'),
            'title' => fake()->text(),
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement(ReportStatus::values()),
            'image' => 'https://placehold.co/400/png',
            'latitude' => fake()->randomFloat(6, -5.25, -5.05),   // Makassar
            'longitude' => fake()->randomFloat(6, 119.35, 119.50), // Makassar
            'address' => fake()->address(),
        ];
    }
}

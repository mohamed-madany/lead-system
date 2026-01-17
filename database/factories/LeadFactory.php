<?php

namespace Database\Factories;

use App\Domain\Lead\Enums\LeadSource;
use App\Domain\Lead\Enums\LeadStatus;
use App\Domain\Lead\Enums\LeadType;
use App\Domain\Lead\Enums\QualityRating;
use App\Domain\Lead\Models\Lead;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domain\Lead\Models\Lead>
 */
class LeadFactory extends Factory
{
    protected $model = Lead::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'company_name' => fake()->company(),
            'job_title' => fake()->jobTitle(),
            'status' => fake()->randomElement(LeadStatus::cases()),
            'source' => fake()->randomElement(LeadSource::cases()),
            'lead_type' => fake()->randomElement(LeadType::cases()),
            'quality_rating' => fake()->randomElement(QualityRating::cases()),
            'score' => fake()->numberBetween(0, 100),
            'notes' => fake()->paragraph(),
            'internal_comments' => fake()->sentence(),
            'estimated_value' => fake()->randomFloat(2, 100, 10000),
            'probability_percentage' => fake()->numberBetween(0, 100),
            'created_at' => now(),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Blueprint;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Blueprint>
 */
class BlueprintFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'tone' => $this->faker->randomElement(['formal', 'informal', 'friendly', 'professional']),
            'max_characters' => $this->faker->numberBetween(50, 280),
            'max_hashtags' => $this->faker->numberBetween(0, 10),
            'rules' => [
                'no_profanity' => $this->faker->boolean(),
                'no_personal_info' => $this->faker->boolean(),
                'no_sensitive_topics' => $this->faker->boolean(),
            ],
        ];
    }
}

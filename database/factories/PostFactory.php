<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
                'title' => fake()->paragraph(),
                'message' => fake()->unique()->paragraphs(3),
                'type_id' => fake()->numberBetween(1,6),
                'user_id' => User::factory()->create()->id,
        ];
    }
}

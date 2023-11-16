<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "message" => fake()->paragraph,
            "code" => fake()->paragraph,
            "type_id" => fake()->numberBetween(1,6),
        ];
    }

    public function postAndUser($postId, $userId): CommentFactory
    {
        return $this->state([
            'post_id' => $postId,
            'user_id' => $userId,
        ]);
    }
}

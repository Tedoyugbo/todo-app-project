<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Todo>
 */
class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $status = random_int(0,2);
        return [
            'description' => fake()->sentence(6),
            'status' => $status,
            'completed_at' => $status == 2 ? now() : null,
            'user_id' => 1,
        ];
    }
}

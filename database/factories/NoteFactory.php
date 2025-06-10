<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Note>
 */
class NoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         return [
        'user_id' => User::factory(), 
        'title' => fake()->sentence(3),
        'body' => fake()->paragraph(4),
        'is_archived' => fake()->boolean(20),
        'is_pinned' => fake()->boolean(30),  
        'color' => Arr::random(['#f87171', '#fbbf24', '#34d399', '#60a5fa', '#c084fc']),
        ];
    }
}

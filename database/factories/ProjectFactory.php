<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'created_by' => User::factory(),
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph(),
            'start_date' => $this->faker->dateTimeBetween('-3 months', 'now'),
            'deadline' => $this->faker->dateTimeBetween('now', '+6 months'),
        ];
    }
}

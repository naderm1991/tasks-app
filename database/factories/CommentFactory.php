<?php

namespace Database\Factories;

use App\Models\Feature;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'content' => $this->faker->sentence,
            'user_id' => function () {
                return User::query()->inRandomOrder()->first()->id;
            },
            'task_id' => function () {
                return Task::query()->inRandomOrder()->first()->id;
            },
            'feature_id' => function () {
                return Feature::query()->inRandomOrder()->first()->id;
            },
            'created_at' => $this->faker->dateTimeBetween('-1 year'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year'),
        ];
    }
}

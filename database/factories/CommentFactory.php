<?php

namespace Database\Factories;

use App\Models\Feature;
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
                return rand('485', '10');
            },
            'task_id' => function () {
                return rand('1', '37');
            },
            'feature_id' => function () {
                return Feature::query()->inRandomOrder()->first()->id;
            },
            'created_at' => $this->faker->dateTimeBetween('-1 year'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year'),
        ];
    }
}

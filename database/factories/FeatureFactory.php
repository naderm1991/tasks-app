<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FeatureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        // create comments table votes with model: php artisan make:model Vote -m
        return [
            'title'=> $this->faker->sentence(3),
            'description'=> $this->faker->paragraph(3),
            'status'=> $this->faker->randomElement(['Completed', 'Requested', 'Approved']),
        ];
    }
}

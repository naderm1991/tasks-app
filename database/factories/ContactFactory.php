<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $strings = array(
            Null,
            $this->faker->city,
        );
        $key = array_rand($strings);

        return [
            'name'=> $this->faker->name,
            'email'=> $this->faker->email,
            'birthdate'=> $this->faker->date,
            'favorite_color'=> $this->faker->hexColor,
            'last_contacted_at'=> $this->faker->dateTimeThisYear,
            'town'=> $strings[$key],
        ];
    }
}

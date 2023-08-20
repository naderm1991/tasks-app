<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'address'  => $this->faker->streetAddress,
            'city'     => $this->faker->city,
            'state'    => $this->faker->stateAbbr,
            'postal'   => substr($this->faker->postcode, 0, 5)  ,
            'latitude' => $this->faker->latitude,
            'longitude'=> $this->faker->longitude(
                20,90
            ),
        ];
    }
}

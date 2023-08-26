<?php

namespace Database\Factories;

use DB;
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
            'location' => DB::raw('ST_SRID(Point(' . $this->faker->longitude . ', ' . $this->faker->latitude . '),4326)'),
        ];
    }
}

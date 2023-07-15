<?php

namespace Database\Factories;

use App\Models\User;
use Faker\Provider\en_AU\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'sales_rep_id'=> User::query()->inRandomOrder()->first()->id,
            'name'=>$this->faker->company,
            'city'=>$this->faker->city,
            'state'=> Address::state(),
        ];
    }
}

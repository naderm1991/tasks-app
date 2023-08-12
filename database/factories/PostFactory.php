<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = substr($this->faker->sentence(), 0, -1);

        return [
            'title' => $title ,
            'slug' => Str::slug($title),
            'body' => $this->faker->paragraphs(10, true),
            'published_at' => $this->faker->dateTimeThisDecade(),
        ];
    }
}

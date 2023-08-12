<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::all()->each(function ($user) {
            $user->posts()->createMany(
                Post::factory(5)->make()->toArray()
            );
        });

        Post::find(5)->update([
            'title' => 'Information about foxes from wikipedia.',
            'body' => 'Foxes are small to medium-sized, omnivorous mammals belonging to several genera of the family Canidae. Foxes have a flattened skull, upright triangular ears, a pointed, slightly upturned snout, and a long bushy tail (or brush).',
        ]);

        Post::find(10)->update([
            'title' => 'A sentence that contains all of the letters of the alphabet.',
            'body' => 'The quick brown fox jumps over the lazy dog.',
        ]);

        Post::find(15)->update([
            'title' => 'Fox and the Hound',
            'body' => "Copper, you're my very best friend.\n\nAnd you're mine too, Tod.\n\nAnd we'll always be friends forever, won't we?\n\nYeah. Forever.",
        ]);
    }
}

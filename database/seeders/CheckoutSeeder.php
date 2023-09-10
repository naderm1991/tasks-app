<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Checkout;
use App\Models\User;
use Illuminate\Database\Seeder;

class CheckoutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create checkout seeder command
        // php artisan make:seeder CheckoutSeeder
        $books = Book::all();
        foreach ($books as $book) {
            Checkout::factory()->create(
                [
                    'user_id'=>  User::query()->inRandomOrder()->first()->id,
                    'book_id'=> $book->id,
                    'borrowed_date'=> now()->subDays(rand(1, 100)),
                ]
            );
        }
    }
}

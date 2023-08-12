<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Checkout;
use App\Models\Comment;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Customer;
use App\Models\Feature;
use App\Models\Login;
use App\Models\Task;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DeviceSeeder::class);
        Feature::factory(20)->create();
        Contact::factory(500)->create();

        Company::factory(10)->create()->each(function ($company) {
            $company->users()->saveMany(User::factory(5)->make(['is_admin' => 1]));
        });
        Company::factory(10)->create()->each(function ($company) {
            $company->users()->saveMany(User::factory(5)->make(['is_admin' => 0]));
        });

        Task::factory(10)->create();

        $users = User::all();
        foreach ($users as $user) {
            Login::factory(2)->create(
                [
                    'user_id'=> $user->id
                ]
            );
        }

        Customer::factory(50)->create();

        // todo fix migration issues related to comments before uncomment this line
        Comment::factory(10)->create();

//        Customer::factory(10)->create();

        // create checkout factory command
        // php artisan make:factory CheckoutFactory --model=Checkout
        Book::factory(10)->create();

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

        Vote::factory(10)->create();

        $this->call(PostSeeder::class);

    }
}

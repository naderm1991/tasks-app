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
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(StoreSeeder::class);

        $this->call(DeviceSeeder::class);

        Feature::factory(20)->create();

        Contact::factory(500)->create();

        $this->call(CompanySeeder::class);

        Task::factory(10)->create();

        Comment::factory(10)->create();

        Book::factory(10)->create();

        $this->call(CheckoutSeeder::class);

        Vote::factory(10)->create();

        $this->call(PostSeeder::class);

        $this->call(RegionSeeder::class);

        $this->call(CustomerSeeder::class);
    }
}

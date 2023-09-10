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
        $i= 0;
        $array = [];
        $file_data  = array_map('str_getcsv', file(base_path('database/seeders/stores.csv')));

        dump($file_data[0]);
        $test = collect($file_data)
//            ->filter(fn ($store) => in_array($store[2],['AB','BC','MB','NB','NL','NS','NT','NU','ON','PE','QC','SK','YT']))
            ->groupBy(function ($store){
//                dump($store[2]);
                return $store[2];
            })
            //fn ($store) => $store->count() > 50 ? $store->random(50) : $store
            ->flatMap(function ($stores) use (&$i){
//                dump($stores);

                $i++;
//                dump($stores->count());
                dump($stores->count());

                // if the count of the stores located in the province is greater than 50, then return random store from the province
                return $stores->flatMap(fn ($stores) => $stores->count() > 50 ? $stores->random(50) : $stores);
            })
            ->each(function ($store) use (&$array) {
//                dd($store);
                $array[] = [
                    'name' => $store[1],
                    'location' => DB::raw("ST_SRID('POINT( $store[1])')"),
                ];
            })
        ;

        dump($i);
//        dd($array);
        dd(count($array));
        die;
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

        $this->call(Customer::class);
    }
}

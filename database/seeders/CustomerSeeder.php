<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        collect(array_map('str_getcsv', file(base_path('database/seeders/stores.csv'))))
            ->filter(fn ($store) => in_array($store[2],['AB','BC','MB','NB','NL','NS','NT','NU','ON','PE','QC','SK','YT']))
            ->groupBy(fn ($store) => $store[2])
            ->flatMap(fn ($stores) => $stores->count() > 50 ? $stores->random(50) : $stores)
            ->each(fn ($store) => Customer::factory()->create(['location' => (function () use ($store) {
                return DB::raw("ST_SRID(POINT($store[4],$store[3]),4326)");
            })()]))
        ;
    }
}

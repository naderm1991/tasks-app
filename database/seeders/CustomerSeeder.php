<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        collect(array_map('str_getcsv', file(base_path('database/seeders/stores.csv'))))
//            ->filter(fn ($store) => in_array($store[2],['AB','BC','MB','NB','NL','NS','NT','NU','ON','PE','QC','SK','YT']))
//            ->groupBy(fn ($store) => $store[2])
//            ->flatMap(fn ($store) => $store->count() > 50 ? $store->random(50) : $store)
//            ->each(fn ($store) => \App\Models\Customer::create([
//                'location' => \Illuminate\Support\Facades\DB::raw("ST_SRID('POINT($store[4] $store[5])')"),
//            ]))
//        ;
    }
}

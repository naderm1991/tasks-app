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
            ->filter(fn ($store) => in_array($store[2], ['AB', 'BC', 'MB', 'NB', 'NL', 'NS', 'NT', 'NU', 'ON', 'PE', 'QC', 'SK', 'YT']))
            ->groupBy(fn ($store) => $store[2])
            ->flatMap(fn ($stores) => $stores->count() > 50 ? $stores->random(50) : $stores)
            ->each(fn ($store) => Customer::factory()->create(['location' => (function () use ($store) {
                if (config('database.default') === 'mysql') {
                    return DB::raw('ST_SRID(Point('.$store[4].', '.$store[3].'),4326)');
                }

                if (config('database.default') === 'sqlite') {
                    throw new \Exception('This lesson does not support SQLite.');
                }

                if (config('database.default') === 'pgsql') {
                    return DB::raw('ST_SetSRID(ST_MakePoint('.$store[4].', '.$store[3].'),)');
                }
            })()]));
    }
}

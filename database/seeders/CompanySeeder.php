<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Company::factory(10)->create()->each(function ($company) {
            $company->users()->saveMany(User::factory(5)->make(['is_admin' => 1]));
        });
        Company::factory(10)->create()->each(function ($company) {
            $company->users()->saveMany(User::factory(5)->make(['is_admin' => 0]));
        });
    }
}

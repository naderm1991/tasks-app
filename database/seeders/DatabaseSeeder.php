<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Login;
use App\Models\Task;
use App\Models\User;
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
//        Company::factory(100)->create()->each(function ($company) {
//            $company->users()->saveMany(User::factory(5)->make(['is_admin' => 1]));
//        });
//        Company::factory(10000)->create()->each(function ($company) {
//            $company->users()->saveMany(User::factory(5)->make(['is_admin' => 0]));
//        });
//
//        Task::factory(500)->create();

        $users = User::all();
        foreach ($users as $user) {
            Login::factory(2)->create(
                [
                    'user_id'=> $user->id
                ]
            );
        }
    }
}

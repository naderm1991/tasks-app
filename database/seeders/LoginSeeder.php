<?php

namespace Database\Seeders;

use App\Models\Login;
use App\Models\User;
use Illuminate\Database\Seeder;

class LoginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
//            $table
//                ->string('name_normalized')
//                ->virtualAs("regexp_replace(name, '[^A-Za-z0-9]', '')")
//                ->index()
//            ;
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('is_admin');
            $table->rememberToken();
            // de-normalization // caching
            //$table->foreignId('last_login_id')->constrained('logins');
            $table->string('first_name');
//            $table
//                ->string('first_name_normalized')
//                ->virtualAs("regexp_replace(first_name, '[^A-Za-z0-9]', '')")
//                ->index()
//            ;
            $table->string('last_name');
//            $table
//                ->string('last_name_normalized')
//                ->virtualAs("regexp_replace(last_name, '[^A-Za-z0-9]', '')")
//                ->index()
//            ;
            $table->timestamps();
            $table->boolean('is_owner')->default(false);
            $table->index(['last_name','first_name']);
            $table->date('birth_date')->nullable();
            $table
                ->rawIndex(
                    "(date_format(birth_date,'%m-%d')),name",
                    'users_birth_day_name_index'
                );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (env('DB_CONNECTION') == "mysql") {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        }
        Schema::dropIfExists('users');
        //DB::statement('DROP TABLE if exists users cascade;');
        //DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}

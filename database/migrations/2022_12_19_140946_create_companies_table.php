<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string("name");
//            $table
//                ->string('name_normalized')
//                ->virtualAs("regexp_replace(name, '[^A-Za-z0-9]', '')")
//                ->index()
//            ;
            $table->timestamps();
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
        //        Schema::dropIfExists('companies');
        DB::statement('DROP TABLE if exists companies cascade;');

//        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    }
}

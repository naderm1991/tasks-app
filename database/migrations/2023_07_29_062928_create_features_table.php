<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('features', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('status');
            $table->timestamps();
//            $table->rawIndex('(
//                CASE
//                    WHEN status = "Requested" THEN 1
//                    WHEN status = "Approved" THEN 2
//                    WHEN status = "Completed" THEN 3
//                END
//            )','feature_status_ranking_index'
//            );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('features');
    }
}

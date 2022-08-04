<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_user', function (Blueprint $table) {
//            $table->foreignIdFor(Blog::class)->constrained()->onDelete('cascade');
//            $table->foreignIdFor(Category::class)->constrained()->onDelete('cascade');
            $table->primary(['task_id', 'assigned_by_id','assigned_to_id']);
            $table->index('task_id');
            $table->index('assigned_by_id');
            $table->index('assigned_to_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_user');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string( 'title');
            $table->string('slug');
            $table->foreignId('author_id')->constrained('users');
            $table->text('body');

            $table->timestamp('published_at');
            $table->timestamps();
        });

        DB::statement(
            'create fulltext index posts_fulltext_index on posts(title, body) '.
            'with parser ngram'
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}

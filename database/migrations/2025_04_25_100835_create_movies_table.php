<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->text('description');
            $table->string('trailer_url')->nullable();
            $table->string('poster_url')->nullable();
            $table->date('release_date');
            $table->integer('duration');
            $table->string('language');
            $table->string('genre');
            $table->decimal('rating', 3, 1)->nullable();
            $table->enum('status', ['now_showing', 'coming_soon']);
            $table->timestamps();
            $table->fullText(['title', 'description']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};

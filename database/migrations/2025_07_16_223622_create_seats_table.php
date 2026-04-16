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
        Schema::create('seats', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('theater_id');
            $table->string('label', 10);
            $table->unsignedInteger('row');
            $table->unsignedInteger('column');
            $table->string('category');
            $table->string('status')->default('active');
            $table->timestamps();
            $table->softDeletes();

            // Create a unique constraint for theater_id, row, and column
            $table->foreign('theater_id')->references('id')->on('theaters')->onDelete('cascade');
            $table->unique(['theater_id', 'row', 'column']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};


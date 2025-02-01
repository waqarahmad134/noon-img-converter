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
        Schema::create('south_actor_movie', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('south_actor_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('south_actor_movie');
    }
};

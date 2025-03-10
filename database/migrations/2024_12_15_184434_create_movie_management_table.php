<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movie_management', function (Blueprint $table) {
            $table->id();
            $table->string('title'); 
            $table->boolean('status')->default(false); 
            $table->boolean('youtube')->default(false); 
            $table->boolean('rumble')->default(false); 
            $table->boolean('storyfire')->default(false); 
            $table->boolean('vidhide')->default(false); 
            $table->boolean('streamwish')->default(false);
            $table->boolean('vidguard')->default(false); 
            $table->boolean('abyss')->default(false); 
            $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movie_management');
    }
};

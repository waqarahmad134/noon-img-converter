<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('meta_description')->nullable();
            $table->string('title');
            $table->string('slug');
            $table->string('thumbnail')->default('');
            $table->longText('description');
            $table->string('duration')->nullable();
            $table->boolean('status')->default(true);
            $table->string('download_link1')->nullable();
            $table->string('download_link2')->nullable();
            $table->string('download_link3')->nullable();
            $table->string('iframe_link1')->nullable();
            $table->string('iframe_link2')->nullable();
            $table->string('iframe_link3')->nullable();
            $table->integer('views')->default(0);
            $table->integer('year')->nullable();
            $table->string('uploadBy')->default('admin');
            $table->string('director')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};

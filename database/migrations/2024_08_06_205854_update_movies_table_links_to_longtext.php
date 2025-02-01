<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->longText('download_link1')->nullable()->change();
            $table->longText('download_link2')->nullable()->change();
            $table->longText('download_link3')->nullable()->change();
            $table->longText('iframe_link1')->nullable()->change();
            $table->longText('iframe_link2')->nullable()->change();
            $table->longText('iframe_link3')->nullable()->change();
            
            // Add new columns
            $table->longText('download_link4')->nullable();
            $table->longText('download_link5')->nullable();
            $table->longText('download_link6')->nullable();
            $table->longText('download_link7')->nullable();
            $table->longText('download_link8')->nullable();
            $table->longText('download_link9')->nullable();
            $table->longText('download_link10')->nullable();
            $table->longText('iframe_link4')->nullable();
            $table->longText('iframe_link5')->nullable();
            $table->longText('iframe_link6')->nullable();
            $table->longText('iframe_link7')->nullable();
            $table->longText('iframe_link8')->nullable();
            $table->longText('iframe_link9')->nullable();
            $table->longText('iframe_link10')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            
            
            // Drop the new columns
            $table->dropColumn('download_link4');
            $table->dropColumn('download_link5');
            $table->dropColumn('iframe_link4');
            $table->dropColumn('iframe_link5');
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            // Add the iframePosition column for each iframe link
            for ($i = 1; $i <= 10; $i++) {
                $table->string("iframePosition$i", 255)->default('');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            // Drop the iframePosition columns
            for ($i = 1; $i <= 10; $i++) {
                $table->dropColumn("iframePosition$i");
            }
        });
    }
};

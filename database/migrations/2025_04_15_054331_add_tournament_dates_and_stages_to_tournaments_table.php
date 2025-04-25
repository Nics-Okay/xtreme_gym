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
        Schema::table('tournaments', function (Blueprint $table) {
            $table->date('tournament_date')->nullable()->after('type'); // Add a general tournament date
            $table->dateTime('semi_finals')->nullable()->after('tournament_date'); // Semi-finals date
            $table->dateTime('finals')->nullable()->after('semi_finals'); // Finals date
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tournaments', function (Blueprint $table) {
            //
        });
    }
};

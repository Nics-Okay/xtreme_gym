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
            $table->integer('registration_fee')->nullable()->after('finals'); // Add registration fee
            $table->integer('first_prize')->nullable()->after('registration_fee'); // Add 1st prize
            $table->integer('second_prize')->nullable()->after('first_prize'); // Add 2nd prize
            $table->integer('third_prize')->nullable()->after('second_prize'); // Add 3rd prize
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

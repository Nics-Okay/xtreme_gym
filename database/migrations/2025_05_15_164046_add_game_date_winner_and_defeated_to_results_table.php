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
        Schema::table('results', function (Blueprint $table) {
            $table->date('game_date')->nullable()->after('tournament_id');
            $table->string('winner_name', 255)->nullable()->after('game_date');
            $table->string('defeated_name', 255)->nullable()->after('winner_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('results', function (Blueprint $table) {
            $table->dropColumn(['game_date', 'winner_name', 'defeated_name']);
        });
    }
};

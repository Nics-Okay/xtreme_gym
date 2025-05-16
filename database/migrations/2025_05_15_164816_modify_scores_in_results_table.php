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
            $table->dropColumn('score'); // Remove the existing score column
            $table->integer('winner_score')->nullable()->after('winner_name'); // Add winner_score
            $table->integer('defeated_score')->nullable()->after('winner_score'); // Add defeated_score
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('results', function (Blueprint $table) {
            $table->dropColumn(['winner_score', 'defeated_score']); // Remove the new columns
            $table->integer('score')->nullable(); // Re-add the original score column
        });
    }
};

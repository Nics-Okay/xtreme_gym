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
        Schema::table('class_lists', function (Blueprint $table) {
            $table->date('class_start')->change(); // Change class_start to DATE type
            $table->date('class_end')->change();   // Change class_end to DATE type
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('class_lists', function (Blueprint $table) {
            //
        });
    }
};

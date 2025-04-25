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
        Schema::create('class_lists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('trainer')->nullable();
            $table->string('schedule')->nullable();
            $table->integer('duration')->nullable()->default(0);
            $table->dateTime('class_start')->nullable();
            $table->dateTime('class_end')->nullable();
            $table->string('status')->nullable();
            $table->integer('number_of_students')->nullable()->default(0);
            $table->integer('price')->nullable()->default(0);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_lists');
    }
};

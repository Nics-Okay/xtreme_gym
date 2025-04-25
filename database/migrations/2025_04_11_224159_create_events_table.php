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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('event_type');
            $table->dateTime('date')->nullable();
            $table->string('location')->nullable()->default('TBA');
            $table->enum('status', ['Upcoming', 'Ongoing', 'Completed'])->default('Upcoming');
            $table->text('description')->nullable();
            $table->unsignedInteger('going')->default(0);
            $table->string('organizer')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};

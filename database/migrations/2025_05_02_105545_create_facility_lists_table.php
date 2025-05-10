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
        Schema::create('facility_lists', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->unsignedInteger('hourly_rate')->nullable();
            $table->unsignedInteger('max_capacity')->nullable();
            $table->time('open_time')->nullable()->default('06:00:00');
            $table->time('close_time')->nullable()->default('22:00:00');
            $table->string('status')->nullable()->default('available');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facility_lists');
    }
};

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
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('condition', ['new', 'good', 'very good', 'excellent'])->nullable();
            $table->date('last_maintenance')->nullable();
            $table->integer('available_number')->default(0);
            $table->text('description')->nullable();
            $table->text('guide')->nullable();
            $table->string('image')->nullable(); // Store image path
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipments');
    }
};

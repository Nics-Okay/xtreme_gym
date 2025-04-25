<?php

use Faker\Guesser\Name;
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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('class_id')->nullable();
            $table->date('student_until')->nullable();
            $table->integer('attended')->nullable()->default(0);
            $table->string('status')->nullable()->default('pending')->comment('Completion');
            $table->string('payment_status')->nullable()->default('pending')->comment('Payment Status');
            $table->string('payment_method')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};

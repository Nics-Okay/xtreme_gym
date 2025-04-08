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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('name');
            $table->dateTime('date_time');
            $table->string('payment_method')->nullable()->default('cash');
            $table->string('transaction_type')->default('membership');
            $table->integer('amount');
            $table->enum('status', ['completed', 'failed', 'pending', 'expired', 'cancelled']);
            $table->integer('discounts')->nullable();
            $table->string('processed_by')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

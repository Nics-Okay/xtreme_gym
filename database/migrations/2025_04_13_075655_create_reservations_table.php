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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('number')->nullable();
            $table->text('address')->nullable();
            $table->string('reservation_type');
            $table->date('reservation_date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->decimal('active_hours', 5, 2)->nullable()->default(0)->change();
            $table->string('status')->nullable();
            $table->integer('number_of_people')->nullable();
            $table->string('payment_status')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};

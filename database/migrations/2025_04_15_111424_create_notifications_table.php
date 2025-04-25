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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            // Basic user information
            $table->string('user_id')->nullable()->comment('ID of the user who triggered the notification');
            $table->string('user_name')->nullable()->comment('Name of the user');
            $table->string('user_email')->nullable()->comment('Email of the user');
            $table->string('user_contact')->nullable()->comment('Contact number of the user');

            // Concern details
            $table->string('title')->nullable()->comment('Title of the concern, e.g., "Facility Issue"');
            $table->text('message')->nullable()->comment('Detailed description of the concern');
            $table->string('category')->nullable()->comment('Category of the concern, e.g., "Facilities", "Suggestions"');
            $table->string('priority')->nullable()->comment('Priority level, e.g., "High", "Medium", "Low"');

            // Optional metadata
            $table->dateTime('submitted_at')->nullable()->comment('When the concern was submitted');
            $table->dateTime('resolved_at')->nullable()->comment('When the concern was resolved');
            $table->boolean('is_read')->default(false)->comment('Whether the notification has been read by the admin');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};

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
        Schema::create('contact_inquiries', function (Blueprint $table) {
            $table->id();

            // User relationship with the existing users table
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');

            // Personal Information (some fields may duplicate user info for guest submissions)
            $table->string('full_name');
            $table->string('email');
            $table->string('phone')->nullable();

            // Property Information
            $table->string('property_address')->nullable();
            $table->enum('inquiry_type', ['general', 'property', 'showing', 'selling', 'other']);
            $table->text('message');

            // Track which type of user submitted the inquiry
            $table->enum('submitter_type', [
                'admin',
                'agent1',
                'agent2',
                'employee',
                'seller',
                'buyer',
                'renter',
                'viewer'
            ])->default('viewer');

            // If the inquiry is assigned to an agent/employee
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');

            // Department handling the inquiry (matches user table department field)
            $table->string('department')->nullable();

            // Additional Options
            $table->boolean('subscribe_newsletter')->default(false);

            // Status and tracking
            $table->enum('status', [
                'pending',
                'under_review',
                'assigned',
                'in_progress',
                'completed',
                'archived'
            ])->default('pending');

            // Response tracking
            $table->text('internal_notes')->nullable();
            $table->timestamp('responded_at')->nullable();
            $table->timestamp('resolved_at')->nullable();

            // Standard timestamps
            $table->timestamps();
            $table->softDeletes();

            // Indexes for better query performance
            $table->index('status');
            $table->index('submitter_type');
            $table->index('inquiry_type');
            $table->index(['assigned_to', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_inquiries');
    }
};

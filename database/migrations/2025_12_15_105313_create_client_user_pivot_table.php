<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Creates a pivot table for many-to-many relationship between users and clients.
     * Allows one user to belong to multiple clients, and one client to have multiple users.
     * Each user can have different roles and permissions in different clients.
     */
    public function up(): void
    {
        Schema::create('client_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Role for this user in this specific client (can be different per client)
            $table->string('role')->default('vip')->comment('User role in this specific client organization');

            // Permissions for this user in this specific client (can be different per client)
            $table->json('permissions')->nullable()->comment('Custom permissions for this user in this client');

            // Primary client indicator
            $table->boolean('is_primary')->default(false)->comment('Indicates if this is the user\'s primary/default client');

            // Active status for this specific client relationship
            $table->boolean('is_active')->default(true)->comment('Whether this user-client relationship is active');

            $table->timestamps();

            // Ensure each user-client combination is unique
            $table->unique(['client_id', 'user_id']);

            // Add indexes for better query performance
            $table->index('client_id');
            $table->index('user_id');
            $table->index('is_primary');
            $table->index('is_active');
            $table->index('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_user');
    }
};

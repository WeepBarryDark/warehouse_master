<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    /**
     * Run the migrations.
     *
     * Adds current_client_id to track which client context the user is currently viewing.
     * This allows users to switch between their multiple clients.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Track the currently selected client for this user's session
            $table->foreignId('current_client_id')->nullable()
                ->constrained('clients')
                ->nullOnDelete()
                ->comment('The client the user is currently viewing/working with');

            $table->index('current_client_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['current_client_id']);
            $table->dropColumn('current_client_id');
        });
    }
};

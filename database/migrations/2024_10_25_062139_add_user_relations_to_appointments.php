<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Add user_id as foreign key
            $table->foreignId('user_id')->nullable()->after('property_id')->constrained()->onDelete('set null');

            // Add user_type field
            $table->string('user_type')->after('user_id')->nullable();

            // Add additional indexes
            $table->index('user_id');
            $table->index(['user_id', 'status']);
            $table->index(['user_type', 'status']);
        });
    }

    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Remove indexes first
            $table->dropIndex(['user_id']);
            $table->dropIndex(['user_id', 'status']);
            $table->dropIndex(['user_type', 'status']);

            // Remove foreign key constraint
            $table->dropForeign(['user_id']);

            // Remove columns
            $table->dropColumn(['user_id', 'user_type']);
        });
    }
};

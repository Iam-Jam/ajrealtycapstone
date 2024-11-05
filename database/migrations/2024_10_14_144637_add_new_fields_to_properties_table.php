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
        Schema::table('properties', function (Blueprint $table) {
            if (!Schema::hasColumn('properties', 'location')) {
                $table->string('location')->nullable();
            }
            if (!Schema::hasColumn('properties', 'bedrooms')) {
                $table->integer('bedrooms')->nullable();
            }
            if (!Schema::hasColumn('properties', 'bathrooms')) {
                $table->integer('bathrooms')->nullable();
            }
            if (!Schema::hasColumn('properties', 'sqm')) {
                $table->integer('sqm')->nullable();
            }
            if (!Schema::hasColumn('properties', 'type')) {
                $table->string('type')->nullable();
            }
            if (!Schema::hasColumn('properties', 'contact_email')) {
                $table->string('contact_email')->nullable();
            }
            if (!Schema::hasColumn('properties', 'contact_messenger')) {
                $table->string('contact_messenger')->nullable();
            }
            if (!Schema::hasColumn('properties', 'contact_whatsapp')) {
                $table->string('contact_whatsapp')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $columns = [
                'location',
                'bedrooms',
                'bathrooms',
                'sqm',
                'type',
                'contact_email',
                'contact_messenger',
                'contact_whatsapp'
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('properties', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
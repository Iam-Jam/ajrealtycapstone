<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListSellPropertiesTable extends Migration
{
    public function up()
    {
        Schema::create('list_sell_properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->enum('property_option', ['list', 'sell']);
            $table->string('title');
            $table->enum('type', ['lot', 'house_and_lot', 'townhouse', 'condominium', 'apartment', 'room']);
            $table->integer('bedrooms');
            $table->integer('bathrooms');
            $table->decimal('sqm', 10, 2);
            $table->decimal('price', 15, 2);
            $table->text('property_address');
            $table->string('city', 100);
            $table->text('description');

            // Amenities
            $table->boolean('swimming_pool')->default(false);
            $table->boolean('gym_access')->default(false);
            $table->boolean('living_room')->default(false);
            $table->boolean('dining_room')->default(false);

            // Contact Information
            $table->string('contact_whatsapp', 50)->nullable();
            $table->string('contact_messenger', 100)->nullable();
            $table->string('contact_email');

            // Listing Options
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_exclusive')->default(false);

            // Status
            $table->enum('status', ['pending', 'active', 'sold', 'inactive'])->default('pending');

            $table->timestamps();

            // Indexes
            $table->index('property_option');
            $table->index('status');
            $table->index('is_featured');
            $table->index('is_exclusive');
            $table->index('type');
        });

        Schema::create('list_sell_property_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained('list_sell_properties')->onDelete('cascade');
            $table->string('image_path');
            $table->timestamps();

            $table->index('property_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('list_sell_property_images');
        Schema::dropIfExists('list_sell_properties');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('property_id')->unique();
            $table->string('title');
            $table->text('description');
            $table->decimal('price', 15, 2);
            $table->string('property_type');
            $table->string('city');
            $table->integer('beds');
            $table->integer('baths');
            $table->decimal('area_sqft', 10, 2);
            $table->string('image')->nullable();
            $table->boolean('featured')->default(false);
            $table->string('location');
            $table->string('property_address');
            $table->integer('bedrooms');
            $table->integer('bathrooms');
            $table->integer('sqm');
            $table->string('type');
            $table->string('contact_email')->nullable();
            $table->string('contact_messenger')->nullable();
            $table->string('contact_whatsapp')->nullable();
            $table->boolean('swimming_pool')->default(false);
            $table->boolean('gym_access')->default(false);
            $table->boolean('living_room')->default(false);
            $table->boolean('dining_room')->default(false);
            $table->text('additional_features')->nullable();
            $table->decimal('lot_size', 10, 2)->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_exclusive')->default(false);
            $table->enum('status', ['for_sale', 'for_rent', 'sold', 'rented'])->default('for_sale');
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down()
    {
        Schema::dropIfExists('properties');
    }
}

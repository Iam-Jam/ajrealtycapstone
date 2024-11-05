<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyDisclosuresTable extends Migration
{
    public function up()
    {
        Schema::create('property_disclosures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('seller_name');
            $table->string('property_address');
            $table->json('structural_issues')->nullable();
            $table->json('system_issues')->nullable();
            $table->json('environmental_issues')->nullable();
            $table->text('additional_issues')->nullable();
            $table->boolean('confirm_disclosure');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('property_disclosures');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('purchase_agreements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->string('buyer_name');
            $table->string('seller_name');
            $table->string('property_address');
            $table->decimal('purchase_price', 15, 2);
            $table->decimal('earnest_money', 15, 2);
            $table->date('closing_date');
            $table->date('possession_date');
            $table->json('contingencies')->nullable();
            $table->text('additional_terms')->nullable();
            $table->boolean('agree_terms');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('purchase_agreements');
    }
};

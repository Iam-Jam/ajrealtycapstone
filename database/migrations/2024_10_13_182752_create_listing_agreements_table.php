<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListingAgreementsTable extends Migration
{
    public function up()
    {
        Schema::create('listing_agreements', function (Blueprint $table) {
            $table->id();
            $table->string('seller_name');
            $table->string('seller_phone');
            $table->string('property_address');
            $table->string('property_city');
            $table->string('property_state');
            $table->string('property_zip');
            $table->decimal('listing_price', 12, 2);
            $table->decimal('commission_rate', 5, 2);
            $table->date('listing_start_date');
            $table->date('listing_end_date');
            $table->text('property_description');
            $table->text('special_conditions')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('listing_agreements');
    }
}

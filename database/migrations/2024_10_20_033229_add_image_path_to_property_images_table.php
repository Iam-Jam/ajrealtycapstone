<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('property_images', function (Blueprint $table) {
            $table->string('image_path')->after('property_id');
        });
    }

    public function down()
    {
        Schema::table('property_images', function (Blueprint $table) {
            $table->dropColumn('image_path');
        });
    }
};

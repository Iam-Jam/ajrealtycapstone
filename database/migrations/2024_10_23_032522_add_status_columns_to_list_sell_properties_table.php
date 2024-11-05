<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('list_sell_properties', function (Blueprint $table) {
            if (!Schema::hasColumn('list_sell_properties', 'status')) {
                $table->enum('status', ['pending', 'approved'])->default('pending');
            }
        });
    }

    public function down()
    {
        Schema::table('list_sell_properties', function (Blueprint $table) {
            if (Schema::hasColumn('list_sell_properties', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('license_number')->nullable();
            $table->string('specialization')->nullable();
            $table->string('department')->nullable();
            $table->string('position')->nullable();
            $table->string('admin_level')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'license_number',
                'specialization',
                'department',
                'position',
                'admin_level'
            ]);
        });
    }
};

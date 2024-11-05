<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('properties', function (Blueprint $table) {
            if (!Schema::hasColumn('properties', 'featured')) {
                $table->boolean('featured')->default(false)->after('image');
            }
            if (!Schema::hasColumn('properties', 'source')) {
                $table->enum('source', ['seller', 'lister', 'admin'])->default('admin')->after('contact_whatsapp');
            }
        });
    }

    public function down()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn(['featured', 'source']);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username')->unique()->nullable();
            }
            if (!Schema::hasColumn('users', 'user_type')) {
                $table->string('user_type');
            }
            if (!Schema::hasColumn('users', 'security_question')) {
                $table->string('security_question');
            }
            if (!Schema::hasColumn('users', 'security_answer')) {
                $table->string('security_answer');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumnIfExists('username');
            $table->dropColumnIfExists('user_type');
            $table->dropColumnIfExists('security_question');
            $table->dropColumnIfExists('security_answer');
        });
    }
};

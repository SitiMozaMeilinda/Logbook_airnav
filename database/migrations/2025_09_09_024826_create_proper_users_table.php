<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (Schema::hasColumn('users', 'email')) {
                    $table->dropColumn('email');
                }
            });
        } else {
            Schema::create('users', function (Blueprint $table) {
                $table->id('user_id');
                $table->string('name');
                $table->string('username')->unique();
                $table->string('password');
                $table->enum('role', ['teknisi', 'manager'])->default('teknisi');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
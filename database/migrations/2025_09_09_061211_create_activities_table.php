<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id('activity_id');
            $table->string('judul_aktivitas');
            $table->enum('divisi', ['CNSA', 'Support']);
            $table->enum('unit', [
                'Communication', 'Navigation', 'Surveillance', 'Automation',
                'Listrik', 'Mekanikal', 'Bangunan'
            ]);
            $table->text('catatan');
            $table->json('foto')->nullable();
            $table->foreignId('user_id')->constrained('users', 'user_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('activities');
    }
};
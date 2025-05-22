<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
	public function up(): void
    {
        Schema::create('moduller', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('durum')->default(1);
            $table->string('baslik', 160)->nullable();
            $table->string('prefix', 160)->nullable();
            $table->string('y1', 120)->nullable();
            $table->string('y2', 120)->nullable();
            $table->string('y3', 120)->nullable();
            $table->string('y4', 120)->nullable();
            $table->string('y5', 120)->nullable();
            $table->string('y6', 120)->nullable();
            $table->string('y7', 120)->nullable();
            $table->string('y8', 120)->nullable();
            $table->string('y9', 120)->nullable();
            $table->string('y10', 120)->nullable();

            $table->unique('prefix');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('moduller');
    }
};

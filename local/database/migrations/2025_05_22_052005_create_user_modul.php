<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
	public function up(): void
    {
        Schema::create('users_modul', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->string('modul', 255);
            $table->boolean('full')->default(0);
            $table->enum('y1', ['0', '1'])->default('0');
            $table->enum('y2', ['0', '1'])->default('0');
            $table->enum('y3', ['0', '1'])->default('0');
            $table->enum('y4', ['0', '1'])->default('0');
            $table->enum('y5', ['0', '1'])->default('0');
            $table->enum('y6', ['0', '1'])->default('0');
            $table->enum('y7', ['0', '1'])->default('0');
            $table->enum('y8', ['0', '1'])->default('0');
            $table->enum('y9', ['0', '1'])->default('0');
            $table->enum('y10', ['0', '1'])->default('0');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users_modul');
    }
	
};

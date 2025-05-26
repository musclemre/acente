<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('musteriler', function (Blueprint $table) {
            $table->id(); // PRIMARY KEY, AUTO_INCREMENT
            $table->string('tc', 11)->nullable();
            $table->string('ad_soyad', 255)->nullable();
            $table->string('telefon', 11)->nullable();
            $table->string('email', 255)->nullable();
            $table->text('adres')->nullable();
            $table->timestamp('cr_date')->useCurrent();
            $table->boolean('enable')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('musteriler');
    }
};

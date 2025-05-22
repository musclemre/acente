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
        Schema::create('acente_ayarlar', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('acente_id');
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('keywords')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('acente_id')->references('id')->on('acenteler')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acente_ayarlar');
    }
};

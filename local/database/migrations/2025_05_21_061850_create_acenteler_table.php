<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('acenteler', function (Blueprint $table) {
            $table->id();
            $table->string('kod', 8)->unique();
            $table->string('acente_adi');
            $table->string('acente_aciklama')->nullable();
            $table->string('sorumlu_adi')->nullable();
            $table->string('sorumlu_telefon')->nullable();
            $table->string('slug')->unique();
            $table->boolean('durum')->default(1)->comment('0=>Pasif, 1=>Aktif');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acenteler');
    }
};

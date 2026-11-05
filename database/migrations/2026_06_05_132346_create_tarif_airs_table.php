<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tarif_airs', function (Blueprint $table) {
            $table->id();
            $table->string('kategori_golongan'); // Contoh: 'SOSIAL', 'RUMAH TANGGA'
            $table->string('sub_golongan'); // Contoh: 'Sosial Umum', 'Rumah Tangga A'
            $table->integer('min_pakai')->default(10); // Batas minimal pemakaian
            $table->integer('tarif_blok_1'); // Harga 0-10 m3
            $table->integer('tarif_blok_2'); // Harga 11-20 m3
            $table->integer('tarif_blok_3'); // Harga > 20 m3
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tarif_airs');
    }
};
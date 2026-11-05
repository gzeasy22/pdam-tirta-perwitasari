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
    Schema::create('pengaduans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pelanggan_id')->nullable(); // Bisa kosong kalau bukan pelanggan tetap
        $table->string('nama_pelapor');
        $table->string('no_hp');
        $table->enum('kategori', ['Pipa Bocor', 'Air Mati', 'Kualitas Air', 'Lainnya']);
        $table->text('lokasi_kejadian');
        $table->text('deskripsi_masalah');
        $table->string('foto_bukti')->nullable();
        $table->enum('status', ['Open', 'Proses', 'Resolved'])->default('Open');
        $table->timestamps();
    });
}
};

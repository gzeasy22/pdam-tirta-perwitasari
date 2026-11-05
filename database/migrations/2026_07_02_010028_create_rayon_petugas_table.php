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
    Schema::create('rayon_petugas', function (Blueprint $table) {
        $table->id();
        // Relasi ke tabel users (Petugas)
        $table->unsignedBigInteger('user_id');
        // Kode rayon 6 digit
        $table->string('rayon_code', 6);
        $table->timestamps();

        // Biar kalau akun petugas dihapus, tugas rayon-nya ikut kehapus otomatis
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rayon_petugas');
    }
};

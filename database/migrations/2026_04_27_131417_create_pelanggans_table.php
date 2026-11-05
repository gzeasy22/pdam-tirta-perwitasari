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
    Schema::create('pelanggans', function (Blueprint $table) {
        $table->id();
        // Data Diri
        $table->string('nama_lengkap');
        $table->string('nik', 16)->unique();
        $table->string('nomor_pelanggan')->nullable()->unique();
        $table->string('no_hp');
        $table->string('email')->nullable();
        // Lokasi
        $table->text('alamat_lengkap');
        $table->string('rt', 3);
        $table->string('rw', 3);
        $table->string('kelurahan');
        $table->string('kecamatan');
        $table->string('koordinat_map')->nullable(); // Titik Google Maps
        // Data Teknis
        $table->enum('peruntukan', ['Rumah Tangga', 'Niaga', 'Sosial', 'Instansi']);
        $table->string('status_kepemilikan');
        // File Dokumen (Path)
        $table->string('foto_ktp');
        $table->string('foto_kk');
        $table->string('foto_rumah');
        // Status Progres
        $table->enum('status', ['Pending', 'Survey', 'Approved', 'Rejected'])->default('Pending');
        $table->timestamps();
    });
}
};

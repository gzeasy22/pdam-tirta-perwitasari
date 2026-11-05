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
        Schema::create('profils', function (Blueprint $table) {
            $table->id();
            
            // Ini laci sekatnya (Buat misahin dewan_pengawas, direksi, prestasi, dll)
            $table->string('kategori'); 
            
            // Buat nyimpen Nama Pejabat
            $table->string('nama_atau_judul'); 
            
            // Buat nyimpen Jabatan Pejabat atau Tahun/Ket Prestasi (Bisa kosong buat struktur)
            $table->string('jabatan_atau_keterangan')->nullable(); 
            
            // Buat nyimpen nama file foto
            $table->string('foto'); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profils');
    }
};

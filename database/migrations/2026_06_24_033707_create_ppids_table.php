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
        Schema::create('ppids', function (Blueprint $table) {
            $table->id();
            // Kategori standar PPID: Informasi Berkala, Setiap Saat, Serta Merta, dll
            $table->string('kategori'); 
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            // Buat nyimpen path file PDF/Docx/Gambar
            $table->string('file_dokumen')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppids');
    }
};

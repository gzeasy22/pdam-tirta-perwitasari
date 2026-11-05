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
        Schema::create('pengajuan_balik_namas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pelanggan_id');
            $table->foreign('pelanggan_id')->references('id')->on('pelanggans')->onDelete('cascade');
            
            $table->string('nama_baru');
            $table->string('nik_baru', 16);
            $table->string('foto_ktp_baru');
            $table->string('foto_bukti_kepemilikan'); 
            
            // 🚨 Nambahin kolom Midtrans
            $table->string('snap_token')->nullable();
            $table->string('order_id')->nullable();

            // 🚨 Update ENUM Statusnya jadi 4 kasta
            $table->enum('status', ['Pending', 'Menunggu Pembayaran', 'Selesai', 'Rejected'])->default('Pending');
            
            $table->text('alasan_penolakan')->nullable(); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_balik_namas');
    }
};
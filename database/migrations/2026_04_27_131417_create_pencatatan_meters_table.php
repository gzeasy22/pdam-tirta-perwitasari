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
    Schema::create('pencatatan_meters', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pelanggan_id')->constrained()->onDelete('cascade');
        $table->date('periode'); // Bulan & Tahun tagihan
        $table->integer('meter_awal');
        $table->integer('meter_akhir');
        $table->integer('total_pemakaian'); // meter_akhir - meter_awal
        $table->string('foto_meter')->nullable(); // Bukti angka meteran
        $table->foreignId('petugas_id'); // Admin yang input
        $table->timestamps();
    });
}
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tagihans', function (Blueprint $table) {
            $table->id();
            // foreignId ini otomatis nyambungin ke id di tabel pelanggans
            $table->foreignId('pelanggan_id')->constrained('pelanggans')->onDelete('cascade'); 
            $table->string('bulan_tagihan');
            $table->integer('meteran_awal');
            $table->integer('meteran_akhir');
            $table->integer('pemakaian');
            $table->integer('total_tagihan');
            $table->string('status')->default('Belum Bayar');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tagihans');
    }
};
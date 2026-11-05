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
    Schema::table('pelanggans', function (Blueprint $table) {
        $table->integer('total_tagihan_pasang')->nullable();
        $table->string('foto_rab')->nullable();
        $table->string('status_pembayaran_pasang')->nullable(); // Isinya: 'Belum Bayar' atau 'Lunas'
    });
}

public function down()
{
    Schema::table('pelanggans', function (Blueprint $table) {
        $table->dropColumn(['total_tagihan_pasang', 'foto_rab', 'status_pembayaran_pasang']);
    });
}
};

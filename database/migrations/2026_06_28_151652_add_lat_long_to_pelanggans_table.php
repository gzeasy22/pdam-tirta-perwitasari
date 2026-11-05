<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pelanggans', function (Blueprint $table) {
            // Presisi 10,8 dan 11,8 ini settingan standar Google Maps bre
            $table->decimal('latitude', 10, 8)->nullable()->after('koordinat_map');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
        });
    }

    public function down()
    {
        Schema::table('pelanggans', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude']);
        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('galeri_profils', function (Blueprint $table) {
            $table->softDeletes();
        });
        
        Schema::table('prestasis', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('galeri_profils', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        
        Schema::table('prestasis', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    use HasFactory;

    // KASIH TAU NAMA TABELNYA DI SINI
    // Ganti 'cabang' pakai nama tabel asli lu di phpMyAdmin (misal: 'tb_cabang' atau 'cabangs')
    protected $table = 'cabangs'; 

    protected $guarded = [];
}
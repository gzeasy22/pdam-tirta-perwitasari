<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    protected $fillable = [
        'pelanggan_id', 
        'bulan_tagihan', 
        'meteran_awal', 
        'meteran_akhir', 
        'pemakaian', 
        'total_tagihan', 
        'status',
        'foto_meter',
    ];

    // Relasi balik ke tabel Pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }
}
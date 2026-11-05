<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // <-- 1. Import SoftDeletes

class Pelanggan extends Model
{
    use HasFactory, SoftDeletes; // <-- 2. Aktifin trait SoftDeletes di sini

    protected $fillable = [
        'nama_lengkap',
        'nik',
        'no_hp',
        'email',
        'alamat_lengkap',
        'rt',
        'rw',
        'kelurahan',
        'kecamatan',
        'cabang_id',
        'koordinat_map',
        'latitude',       // <-- Pastiin koordinat masuk sini juga
        'longitude',      // <-- Pastiin koordinat masuk sini juga
        'peruntukan',
        'sub_golongan', 
        'status_kepemilikan',
        'foto_selfie_ktp',
        'foto_ktp',
        'foto_kk',
        'foto_rumah',
        'status',
        'nomor_pelanggan',
        'alasan_penolakan', // <-- 3. TAMBAHIN INI BUAT FITUR TOLAK PENGAJUAN
        'total_tagihan_pasang',
        'foto_rab',
        'status_pembayaran_pasang',
        'order_id_pasang',
        'snap_token_pasang',
        'ukuran_meter',    // <-- Nambahin data meter
        'no_meter',        // <-- Nambahin data meter
        'merk_meter'       // <-- Nambahin data meter
    ];
}
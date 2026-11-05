<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profil extends Model
{
    use HasFactory;

    protected $table = 'profils';

    protected $fillable = [
        'kategori',
        'nama_atau_judul',
        'jabatan_atau_keterangan',
        'deskripsi', // <--- INI TAMBAHANNYA BRE
        'foto'
    ];
}

class GaleriProfil extends Model
{
    use SoftDeletes; // Aktifkan di sini

    protected $guarded = ['id'];
}
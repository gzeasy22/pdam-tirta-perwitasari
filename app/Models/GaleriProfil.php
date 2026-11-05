<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GaleriProfil extends Model
{
    protected $table = 'galeri_profils';

    // Cuma 2 kolom ini doang yang diisi
    protected $fillable = [
        'kategori',
        'foto'
    ];
}
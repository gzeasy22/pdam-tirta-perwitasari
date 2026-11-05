<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    protected $table = 'prestasis';

    // Cuma 2 ini doang sesuai request lu
    protected $fillable = [
        'foto',
        'deskripsi'
    ];
}
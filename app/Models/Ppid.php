<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ppid extends Model
{
    use HasFactory;

    protected $table = 'ppids';

    protected $fillable = [
        'kategori',
        'judul',
        'deskripsi',
        'file_dokumen'
    ];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TarifAir extends Model
{
    use HasFactory;

    // Kasih tau Laravel nama tabelnya yang bener
    protected $table = 'tarif_airs';

    // Biarin semua kolom bisa diisi (kecuali ID)
    protected $guarded = ['id'];
}

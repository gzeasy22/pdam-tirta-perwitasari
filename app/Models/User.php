<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// 👇 INI YANG KITA UBAH BRE (Nambahin 'role' di ujung) 👇
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    // Tambahin kolom data diri admin & cabang
    protected $fillable = [
        'name', 
        'email', 
        'password', 
        'role',
        'nik_karyawan', 
        'tempat_lahir', 
        'tanggal_lahir', 
        'username', 
        'cabang_id'
    ];
    
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // 👇 Tambahin jembatan ini biar User kenal sama nama Cabangnya 👇
    public function cabang()
    {
        // Asumsi nama model lu Cabang (Sesuaikan kalau namanya beda, misal: CabangModel)
        return $this->belongsTo(\App\Models\Cabang::class, 'cabang_id');
    }
}
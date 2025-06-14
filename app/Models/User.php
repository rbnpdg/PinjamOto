<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Tabel yang digunakan model ini.
     */
    protected $table = 'user';

    /**
     * Kolom yang bisa diisi secara massal.
     */
    protected $fillable = [
        'nama',
        'email',
        'username',
        'password',
        'role',
        'telepon',
        'alamat',
    ];

    /**
     * Kolom yang disembunyikan saat serialisasi (misalnya JSON).
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Tipe data casting untuk kolom tertentu.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Mutator: meng-hash password setiap kali diset.
     */
    public function setPasswordAttribute($value)
    {
        // Hash hanya jika belum di-hash
        $this->attributes['password'] = Hash::needsRehash($value)
            ? Hash::make($value)
            : $value;
    }

    public function favorites()
    {
        return $this->belongsToMany(Mobil::class, 'favorites', 'user_id', 'mobil_id');
    }

    public function hasActiveOrder()
    {
        return false;
    }
}

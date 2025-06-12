<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mobil extends Model
{
    use HasFactory;
    protected $table = 'mobil';
<<<<<<< Updated upstream
    protected $fillable = ['nama', 'tnkb', 'tahun', 'status'];
=======
    protected $fillable = ['gambar', 'nama', 'tahun', 'tipe', 'tnkb', 'kapasitas', 'transmisi', 'bbm', 'hargasewa', 'status',];

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites', 'mobil_id', 'user_id');
    }
>>>>>>> Stashed changes
}

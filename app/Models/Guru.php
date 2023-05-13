<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;
    protected $fillable = [
        'nip',
        'nama',
        'jk',
        'alamat',
        'hp',
        'email',
        'sekolah_id'
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'sekolah_id','npsn');
    }

    public function lombas()
    {
        return $this->hasManyThrough(Lomba::class, Panitia::class);
    }

    public function panitias()
    {
        return $this->hasMany(Panitia::class);
    }

    public function juri()
    {
        return $this->hasOne(Juri::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    use HasFactory;
    protected $fillable = [
        'kode',
        'label',
        'deskripsi',
        'kategori',
        'kelompok'
    ];

    public function lombas()
    {
        return $this->belongsToMany(Lomba::class, 'bidang_lomba');
    }

    // public function pesertas()
    // {
    //     return $this->hasMany(Peserta::class, 'lomba_id','kode');
    // }
    public function pesertas()
    {
        return $this->belongsToMany(Peserta::class, 'bidang_peserta','bidang_id', 'peserta_id');
    }

    public function juris()
    {
        return $this->hasMany(Juri::class, 'lomba_id', 'kode');
    }

}

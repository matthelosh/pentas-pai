<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    use HasFactory;
    protected $fillable = [
        'lomba_id',
        'kode',
        'label',
        'deskripsi',
        'kategori',
        'kelompok'
    ];

    public function lombas()
    {
        return $this->belongsTo(Lomba::class);
    }

    public function pesertas()
    {
        return $this->belongsToMany(Peserta::class, 'bidang_peserta','bidang_id', 'peserta_id');
    }

    public function juris()
    {
        return $this->hasMany(Juri::class, 'lomba_id', 'kode');
    }

}

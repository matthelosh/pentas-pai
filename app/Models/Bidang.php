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
        'tahun'
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
        return $this->belongsToMany(Peserta::class, 'lomba_peserta','lomba_id', 'peserta_id');
    }
}

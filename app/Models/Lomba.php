<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lomba extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'kode',
        'label',
        'tahun',
        'tanggal',
        'lokasi_id',
        'status'
    ];

    public function bidangs()
    {
        return $this->hasMany(Bidang::class);
    }

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'lokasi_id', 'npsn');
    }


    public function panitias()
    {
        return $this->hasMany(Panitia::class);
    }

    public function pesertas()
    {
        return $this->belongsToMany(Peserta::class, 'lomba_peserta', 'lomba_id', 'peserta_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    use HasFactory;

    protected $fillable = [
        'nisn',
        'nama',
        'jk',
        'sekolah_id',
        'foto',
        'hp',
        'lomba_id',
        'bidang_id'
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'sekolah_id', 'npsn');
    }

    // public function bidang()
    // {
    //     return $this->belongsTo(Bidang::class, 'lomba_id', 'kode');
    // }

    public function lomba()
    {
        return $this->belongsTo(Lomba::class);
    }

    public function nilais()
    {
        return $this->hasMany(Nilai::class, 'siswa_id', 'nisn');
    }
    public function bidangs()
    {
        return $this->belongsToMany(Bidang::class, 'bidang_peserta', 'peserta_id', 'bidang_id');
    }
}

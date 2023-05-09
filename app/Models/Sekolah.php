<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;

    protected $fillable =[
        'npsn',
        'nama',
        'alamat',
        'telp',
        'email',
        'website',
        'kepsek',
        'nip_kepsek'
    ];

    public function pesertas()
    {
        return $this->hasMany(Peserta::class, 'sekolah_id', 'npsn');
    }
}

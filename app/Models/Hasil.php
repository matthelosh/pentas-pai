<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hasil extends Model
{
    use HasFactory;

    protected $fillable = [
        'bidang_id',
        'siswa_id',
        'user_id',
        'nilai'
    ];

    public function siswa()
    {
        return $this->belongsTo(Peserta::class, 'siswa_id', 'nisn');
    }


    public function juri()
    {
        return $this->belongsTo(User::class);
    }

    public function  bidang()
    {
        return $this->belongsTo(Bidang::class);
    }
}

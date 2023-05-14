<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;

class Sertifikat extends Model
{
    use UUID, HasFactory;

    protected $fillable = [
        'penerima',
        'predikat',
        'kegiatan',
        'tempat',
        'tanggal',
        'panitia',
        'nip_panitia',
        'pejabat',
        'nip_pejabat'
    ];
}

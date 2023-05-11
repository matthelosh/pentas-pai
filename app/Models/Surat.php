<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'perihal',
        'penerima',
        'content',
        'tanggal',
        'tujuan'
    ];

    public function lampirans()
    {
        return $this->belongsToMany(Lampiran::class);
    }
}

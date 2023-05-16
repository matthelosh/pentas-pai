<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;

class Juara extends Model
{
    use HasFactory, UUID;
    protected $fillable = [
        'id',
        'peserta_id',
        'lomba_id',
        'bidang_id',
        'peringkat',
        'nilai',
        'keterangan',
    ];

    public function lomba()
    {
        return $this->belongsTo(Lomba::class);
    }

    public function bidang()
    {
        return $this->belongsTo(Bidang::class, 'bidang_id', 'kode');
    }

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'peserta_id','nisn');
    }
}

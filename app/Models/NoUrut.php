<?php

namespace App\Models;

use App\Models\Peserta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoUrut extends Model
{
    use HasFactory;

    protected $fillable = [
        'bidang_id',
        'siswa_id',
        'ke'
    ];

    public function bidang()
    {
        return $this->belongsTo(Bidang::class);
    }

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'siswa_id', 'nisn');
    }
}

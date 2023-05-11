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
        'lokasi_id'
    ];

    public function bidangs()
    {
        return $this->belongsToMany(Bidang::class, 'bidang_lomba');
    }

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'lokasi_id', 'npsn');
    }
}

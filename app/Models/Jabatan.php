<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;
    protected $fillable = [
        'kode',
        'label',
        'deskripsi'
    ];

    function panitia() {
        return $this->hasOne(Panitia::class, 'jabatan', 'kode');
    }
}

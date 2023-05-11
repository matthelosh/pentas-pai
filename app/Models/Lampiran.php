<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lampiran extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'content',
        'deskripsi'
    ];

    public function surats()
    {
        return $this->belongsTo(Surat::class);
    }
}

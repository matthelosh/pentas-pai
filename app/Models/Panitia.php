<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panitia extends Model
{
    use HasFactory;

    protected $fillable = [
        'lomba_id',
        'guru_id',
        'user_id',
        'jabatan'
    ];

    public function lomba()
    {
        return $this->belongsTo(Lomba::class);
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

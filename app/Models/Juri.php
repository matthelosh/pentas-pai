<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Juri extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'lomba_id',
        'guru_id'
    ];

    public function lomba()
    {
        return $this->belongsTo(Bidang::class, 'lomba_id', 'id');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
}

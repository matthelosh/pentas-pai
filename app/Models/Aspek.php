<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aspek extends Model
{
    use HasFactory;

    protected $fillable = [
        'bidang_id',
        'label'
    ];

    public function bidang()
    {
        return $this->belongsTo(Bidang::class);
    }

    public function nilais()
    {
        return $this->hasMany(Nilai::class);
    }
}

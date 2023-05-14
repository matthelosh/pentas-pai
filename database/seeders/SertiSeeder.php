<?php

namespace Database\Seeders;

use App\Models\Sertifikat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SertiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sertifikat::create([
            'penerima' => 'Bejo',
            'predikat' => 'Juara',
            'kegiatan' => 'Lomba',
            'tempat' => 'Malang',
            'tanggal' => '2023-05-13',
            'panitia' => 'Wong',
        ]);
    }
}

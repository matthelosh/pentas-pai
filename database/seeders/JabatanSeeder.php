<?php

namespace Database\Seeders;

use App\Models\Jabatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jabatans = [
            [
                'kode' => 'ket',
                'label' => 'Ketua',
                'deskripsi' => 'Ketua Panitia'
            ],
            [
                'kode' => 'wak',
                'label' => 'Wakil',
                'deskripsi' => 'Wakil Panitia'
            ],
            [
                'kode' => 'sek',
                'label' => 'Sekretaris',
                'deskripsi' => 'Sekretaris'
            ],
            [
                'kode' => 'bend',
                'label' => 'Bendahara',
                'deskripsi' => 'Bendahara'
            ],
            [
                'kode' => 'lcc',
                'label' => 'Seksi Lomba LCC',
                'deskripsi' => 'Seksi Lomba LCC'
            ],
            [
                'kode' => 'mtq',
                'label' => 'Seksi Lomba MTQ',
                'deskripsi' => 'Seksi Lomba MTQ'
            ],
            [
                'kode' => 'mhq',
                'label' => 'Seksi Lomba MHQ',
                'deskripsi' => 'Seksi Lomba MHQ'
            ],
            [
                'kode' => 'adz',
                'label' => 'Seksi Lomba Adzan',
                'deskripsi' => 'Seksi Lomba Adzan'
            ],
            [
                'kode' => 'bjr',
                'label' => 'Seksi Lomba Banjari',
                'deskripsi' => 'Seksi Lomba Banjari'
            ],
            [
                'kode' => 'pdc',
                'label' => 'Seksi Lomba Pildacil',
                'deskripsi' => 'Seksi Lomba Pildacil'
            ],
            [
                'kode' => 'hum',
                'label' => 'Seksi Humas',
                'deskripsi' => 'Seksi Humas'
            ],
            [
                'kode' => 'dek',
                'label' => 'Seksi Dekorasi',
                'deskripsi' => 'Seksi Dekorasi'
            ],
            [
                'kode' => 'len',
                'label' => 'Seksi Perlengkapan',
                'deskripsi' => 'Seksi Perlengkapan'
            ],
            [
                'kode' => 'kon',
                'label' => 'Seksi Konsumsi',
                'deskripsi' => 'Seksi konsumsi'
            ],
            [
                'kode' => 'dok',
                'label' => 'Seksi Dokumentasi',
                'deskripsi' => 'Seksi Dokumentasi'
            ],
            [
                'kode' => 'acr',
                'label' => 'Seksi Acara',
                'deskripsi' => 'Seksi Acara'
            ],
        ];

        foreach ($jabatans as $jabatan) {

            Jabatan::create(
                [
                    'kode' => $jabatan['kode'],
                    'label' => $jabatan['label'],
                    'deskripsi' => $jabatan['deskripsi']
                ]
            );
        }
    }
}

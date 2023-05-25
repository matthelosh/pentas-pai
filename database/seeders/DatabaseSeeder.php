<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Bidang;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // $path = public_path('db/lombas.sql');
        // $sql = file_get_contents($path);
        // DB::unprepared($sql);
        $bidangs = [
            [
                'kode' => 'adz', 'label' => 'Adzan', 'kategori' => 'tunggal', 'kelompok' => 'putra'
            ],
            [
                'kode' => 'bjr', 'label' => 'Banjari', 'kategori' => 'regu', 'kelompok' => 'campur'
            ],
            [
                'kode' => 'lcc', 'label' => 'Cerdas Cermat', 'kategori' => 'regu', 'kelompok' => 'campur'
            ],
            [
                'kode' => 'pdc', 'label' => 'Pildacil', 'kategori' => 'tunggal', 'kelompok' => 'campur'
            ],
            [
                'kode' => 'mhq', 'label' => 'MHQ', 'kategori' => 'tunggal', 'kelompok' => 'campur'
            ],
            [
                'kode' => 'mtq', 'label' => 'MTQ', 'kategori' => 'tunggal', 'kelompok' => 'campur'
            ],

        ];

        foreach($bidangs as $bidang) {
            Bidang::updateOrCreate(
                [
                    'kode' => $bidang['kode'],
                ],
                [
                    'label' => $bidang['label'],
                    'kategori' => $bidang['kategori'],
                    'kelompok' => $bidang['kelompok'],
                    'deskripsi' => 'Bidang Lomba '.$bidang['label']
                ]
            );
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Guru;
class UpdatePanitiaNip extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gurus = Guru::all();
        foreach($gurus as $guru)
        {
            $guru->update(['nip' => uniqid()]);
        }
    }
}

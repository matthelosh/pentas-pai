<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            User::create([
                'name' => 'admin',
                'email' => 'admin@kkgpaiwagir.or.id',
                'password' => Hash::make('123'),
                'level' => 'admin',
                'userable_id' => '0',
                'userable_type' => 'App\Models\Guru',
            ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\NoUrut;
use Illuminate\Http\Request;

class NoUrutController extends Controller
{
    public function store(Request $request)
    {

        try {
            foreach ($request->datas as $data) {
                NoUrut::updateOrCreate(
                    [
                        'id' => $data['id'] ?? null
                    ],
                    [
                        'bidang_id' => $request->bidang_id,
                        'siswa_id' => $data['siswa_id'],
                        'ke' => $data['urut']
                    ]
                );
            }

            return \response()->json([
                'message' => 'No Urut Peserta disimpan'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}

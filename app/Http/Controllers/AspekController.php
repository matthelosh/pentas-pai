<?php

namespace App\Http\Controllers;

use App\Models\Aspek;
use Illuminate\Http\Request;

class AspekController extends Controller
{


    public function store(Request $request)
    {
        try {
            // dd($request->all());
            $aspek = Aspek::updateOrCreate(
                [
                    'id' => $request->id ?? null,
                ],
                [
                    'bidang_id' => $request->bidang_id,
                    'label' => $request->label,
                ]
            );

            return back()->with('message', 'Aspek disimpan');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy(Aspek $aspek, $id)
    {
        try {
            $destroy = $aspek::destroy($id);

            return back()->with('message', 'Aspek disimpan');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}

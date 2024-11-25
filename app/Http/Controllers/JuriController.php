<?php

namespace App\Http\Controllers;

use App\Models\Juri;
use Illuminate\Http\Request;

class JuriController extends Controller
{
    public function store(Request $request)
    {
        try {
            $store = Juri::updateOrCreate(
                [
                    'id' => $request->id ?? null,
                    'lomba_id' => $request->bidang_id,
                ],
                [
                    'label' => $request->label,
                    'guru_id' => $request->guru_id

                ]
            );

            return back()->with('message', 'Juri disimpan');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy(Juri $juri, $id)
    {
        try {
            $destroy = $juri::destroy($id);
            // dd($destroy);
            return back()->with('message', 'Juri dihapus');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}

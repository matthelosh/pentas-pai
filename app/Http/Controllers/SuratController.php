<?php

namespace App\Http\Controllers;

use App\Models\Lampiran;
use App\Models\Surat;
use Illuminate\Http\Request;

class SuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            return response()->json(['status' => 'ok', 'surats' => Surat::with('lampirans')->get()], 200);
        } catch(\Exception $e) {
            return response()->json(['status' => 'fail', 'msg' => $e->getMessage()], 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = json_decode($request->surat);
            Surat::updateOrCreate(
                [
                    'id' => $data->id ?? null,
                ],
                [
                    'kode' => $data->kode,
                    'perihal' => $data->perihal,
                    'penerima' => $data->penerima,  
                    'content' => $data->content,
                    'tanggal' => $data->tanggal,
                    'tujuan' => $data->tujuan
                ]

            );

            return response()->json(['status' => 'ok', 'message' => 'Surat disimpan'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'msg' => $e->getMessage()], 500);
        }
    }

    public function storeAttachment(Request $request, $id)
    {
        // dd($id);
        try {
            $lampiran = new Lampiran($request->all());
            $lampiran->save();
            $surat = Surat::find($id);
            $surat->lampirans()->attach($lampiran->id);
            return response()->json(['status' => 'ok', 'message' => 'Lampiran disimpan'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'msg' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Surat $surat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Surat $surat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Surat $surat)
    {
        //
    }
}

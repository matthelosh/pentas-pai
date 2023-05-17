<?php

namespace App\Http\Controllers;

use App\Models\Juara;
use App\Models\Panitia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
class JuaraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd($request->query('lomba'));
        try {
            if (!$request->query('lomba')) {
                $juaras = Juara::with('peserta.sekolah', 'bidang')->orderBy('bidang_id', 'ASC')->orderBy('peringkat','ASC')->get();
            } else {
                $panitia = Panitia::where('user_id', $request->user()->id)->with('guru')->first();
                $npsn = $panitia->guru->sekolah_id;
                $juaras = Juara::where('bidang_id', $request->query('lomba'))->with('peserta.sekolah')->get();
            }
            return response()->json(['status' => 'ok', 'juaras' => $juaras], 200);
        } catch(\Exception $e) {
            return response()->json(['status' => 'fail', 'msg' => $e->getMessage()], 500);
        }
    }

   public function impor(Request $request)
   {
        $datas = json_decode($request->data);
        try {
            foreach($datas as $data) {
                Juara::updateOrCreate(
                    [
                        'id' => $data->id ?? Str::uuid()->toString()
                    ],
                    [
                        'peserta_id' => $data->peserta_id,
                        'lomba_id' => '1',
                        'bidang_id' => $data->bidang_id,
                        'peringkat' => $data->peringkat,
                        'nilai' => $data->nilai,
                        'keterangan' => $data->keterangan
                    ]
                    );
            }
            return response()->json(['status' => 'ok', 'msg' => 'Data DIsimpan'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'msg' => $e->getMessage()], 500);
        }
   }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = json_decode($request->data);
            Juara::updateOrCreate(
                [
                'id' => $data->id ?? Str::uuid()->toString(),
                ],
                [
                    'peserta_id' => $data->peserta_id,
                    'lomba_id' => '1',
                    'bidang_id' => $data->bidang_id,
                    'peringkat' => $data->peringkat,
                    'nilai' => $data->nilai,
                    'keterangan' => $data->keterangan
                ]
            );
            return response()->json(['status' => 'ok', 'msg' => 'Data Juara disimpan'], 200);
        } catch(\Exception $e) {
            return response()->json(['status' => 'fail', 'msg' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Juara $juara)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Juara $juara)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Juara $juara)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Juara $juara)
    {
        //
    }
}

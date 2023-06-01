<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\Peserta;
use Inertia\Inertia;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SekolahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            return response()->json([
                'status' => 'ok',
                'sekolahs' => Sekolah::with('pesertas')->get(),
            ], 200);
        } catch(\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'msg' => $e->getMessage(),
            ], 500);
        }
    }

    public function home(Request $request)
    {
        $sekolahs = $request->user()->level == 'admin' ? Sekolah::all() : Sekolah::where('npsn', $request->user()->userable->sekolah_id)->get();

        return Inertia::render('Dashboard/Sekolah', [
            'sekolahs' => $sekolahs,
        ], 200);
    }

    public function impor(Request $request)
    {
        try{
            foreach(json_decode($request->sekolahs) as $data)
            {
                Sekolah::updateOrCreate(
                    [
                        'id' => $data->id ?? null,
                        'npsn' => $data->npsn,
                    ],
                    [
                        'nama' => $data->name,
                        'alamat' => $data->alamat,
                        'telp' => $data->telp ?? null,
                        'email' => $data->email ?? null,
                        'website' => $data->website ?? null,
                        'kepsek' => $data->kepsek ?? null,
                        'nip_kepsek' => $data->nip_kepsek ?? null
                    ]
                    );
            }
            return response()->json([
                'status' => 'ok',
                'msg' => 'Data Sekolah sukses diimpor'
            ], 200);
        } catch(\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'msg' => $e->getMessage(),
                'code' => $e->getCode()
            ], 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Sekolah $sekolah, $id)
    {
        $sekolah =  $sekolah::find($id);
        $npsn = $sekolah->npsn;
        // $sekolah['pesertas'] = Peserta::where('sekolah_id', $sekolah->npsn)->whereHas('bidangs')->with('bidangs')->get();
        $sekolah['bidangs'] = Bidang::whereHas('pesertas')->with('pesertas', function ($q) use($npsn) {
            $q->where('sekolah_id',$npsn);
        })->get();
        
        return response()->json(['status' => 'ok', 'sekolah' => $sekolah], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sekolah $sekolah)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sekolah $sekolah)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sekolah $sekolah)
    {
        //
    }
}

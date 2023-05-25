<?php

namespace App\Http\Controllers;

use App\Models\Lomba;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LombaController extends Controller
{
    public function page(Request $request)
    {
        return Inertia::render('Dashboard/Lomba', [
            'lombas' => Lomba::with('sekolah', 'bidangs.pesertas', 'panitias','pesertas')->get(),
        ], 200);
    }

    public function activate(Request $request, $id)
    {
        Lomba::where('status', '1')->update(['status' => '0']);
        Lomba::find($id)->update(['status' => '1', 'lokasi_id' => $request->lokasi_id]);
        return response()->json(['status' => 'ok', 'msg' => 'Lomba diaktifkan'], 200);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->query('q') == 'select') {
            $lombas = Lomba::where('status', '1')->with('bidangs')->first();
        } else {
            $lombas = Lomba::where('status', '1')->with('bidangs.pesertas.sekolah')->get();
        }
        
        return response()->json(['status' => 'ok', 'lombas' => $lombas], 200);
    }

    public function rekap(Request $request)
    {
        $datas = Sekolah::with('pesertas.bidangs')->get();
        return response()->json(['status' => 'ok', 'sekolahs' => $datas], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $lomba = json_decode($request->lomba);
            Lomba::updateOrCreate(
                [
                    'id' => $lomba->id?? null
                ],
                [
                    'kode'=> $lomba->kode,
                    'label'=> $lomba->label,
                    'tahun'=> $lomba->tahun,
                    'tanggal'=> $lomba->tanggal,
                    'lokasi_id'=> $lomba->lokasi_id,
                    'status' => '0'
                ]
            );
            return response()->json([
                'status' => 'ok',
                'msg' => 'Data Lomba Disimpan'
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
     * Display the specified resource.
     */
    public function show(Lomba $lomba)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lomba $lomba)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lomba $lomba)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lomba $lomba)
    {
        //
    }
}

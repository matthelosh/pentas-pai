<?php

namespace App\Http\Controllers;

use App\Models\Lomba;
use App\Models\Sekolah;
use Illuminate\Http\Request;

class LombaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->query('q') == 'select') {
            $lombas = Lomba::where('tahun', date('Y'))->with('bidangs')->first();
        } else {
            $lombas = Lomba::where('tahun', date('Y'))->with('bidangs.pesertas.sekolah')->get();
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
        //
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

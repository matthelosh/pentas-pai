<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\Lomba;
use Illuminate\Http\Request;

class BidangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $lomba = Lomba::whereStatus('1')->first();
            if ($request->query('id')) {
                if ($request->user()->level == 'admin') {
                    $bidangs = Bidang::find($request->query('id'));
                }
            } else {
                $bidangs = Bidang::where('lomba_id', $lomba->id)->get();
            }
            return response()->json([
                'status' => 'ok',
                'bidangs' => $bidangs
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'ok',
                'msg' => $e->getMessage()
            ], 500);
        }
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
    public function show(Bidang $bidang, $id)
    {
        try {
            if (auth()->user()->level == 'admin') {
                $bidang = Bidang::where('id', $id)->with([
                    'pesertas' => function ($p) {
                        $p->with('sekolah', 'urutans');
                    }
                ])->first();
            } else {
                $npsn = auth()->user()->userable->sekolah_id;
                $bidang = Bidang::where('id', $id)->whereHas('pesertas', function ($q) use ($npsn) {
                    $q->where('pesertas.sekolah_id', $npsn);
                })->with('pesertas.sekolah')->first();
            }

            return response()->json([
                'status' => 'Ok',
                'bidang' => $bidang
            ], 200);
        } catch (\Exception $e) {
            //throw $th;
            dd($e);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bidang $bidang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bidang $bidang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bidang $bidang, $id)
    {
        try {
            $bidang::find($id);
            $bidang->pesertas()->detach();
            $bidang::destroy($id);

            return response()->json([
                'status' => 'ok',
                'msg' => 'Bidang Dihapus'
            ], 200);
        } catch (\Exception $e) {
            dd($e);
        }
    }
}

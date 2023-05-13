<?php

namespace App\Http\Controllers;

use App\Models\Panitia;
use App\Models\Guru;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PanitiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->getMethod('get')) {
            return Inertia::render('Dashboard/Panitia', [
                'gurus' => Guru::with('sekolah')->get(),
            ], 200);
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
        $data = json_decode($request->data);
        try {
            Panitia::updateOrCreate(
                [
                    'id' => $data->id ?? null
                ],
                [
                    'jabatan' => $data->jabatan,
                    'guru_id' => $data->guru_id,
                    'lomba_id' => $data->lomba_id
                ]
            );
            return response()->json(['status' => 'ok', 'msg' => 'Panitia Disimpan'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'ok', 'msg' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Panitia $panitia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Panitia $panitia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Panitia $panitia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Panitia $panitia)
    {
        //
    }
}

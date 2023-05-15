<?php

namespace App\Http\Controllers;

use App\Models\Sertifikat;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SertifikatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function verify(Request $request, $id)
    {
        try {
            return Inertia::render('Verifikasi')->with([
                'sertifikat' => Sertifikat::where('id', $id)->first(),
            ]);
        } catch (\Exception $e) {

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
    public function show(Sertifikat $sertifikat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sertifikat $sertifikat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sertifikat $sertifikat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sertifikat $sertifikat)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Lomba;
use Illuminate\Http\Request;

class AdministrasiController extends Controller
{
    public function peserta(Request $request)
    {
        return Inertia::render('Dashboard/AdministrasiPeserta', [
            'lomba' => $this->activeLomba(),
        ]);
    }

    public function lomba(Request $request)
    {
        return Inertia::render('Dashboard/AdministrasiLomba', [
            'lomba' => $this->activeLomba(),
        ]);
    }

    public function panitia(Request $request)
    {
        return Inertia::render('Dashboard/AdministrasiPanitia', [
            'lomba' => $this->activeLomba(),
        ]);
    }
    public function surat(Request $request)
    {
        return Inertia::render('Dashboard/AdministrasiSurat', [
            'lomba' => $this->activeLomba(),
        ]);
    }

    public function activeLomba()
    {
        $lomba = Lomba::where('status', 1)->with([
            'bidangs' => function ($b) {
                $b->with('aspeks');
                $b->with('pesertas');
            }
        ])->first();
        return $lomba;
    }
}

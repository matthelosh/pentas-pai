<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class AdministrasiController extends Controller
{
    public function peserta(Request $request)
    {
        return Inertia::render('Dashboard/AdministrasiPeserta');
    }
    
    public function lomba(Request $request)
    {
        return Inertia::render('Dashboard/AdministrasiLomba');
    }
    
    public function panitia(Request $request)
    {
        return Inertia::render('Dashboard/AdministrasiPanitia');
    }
}

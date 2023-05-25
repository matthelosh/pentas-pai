<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\Guru;
use App\Models\Juara;
use Inertia\Inertia;
use App\Models\Lomba;
use App\Models\Peserta;
use App\Models\Sekolah;
use Illuminate\Http\Request;

class DashController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Dashboard', [
            'datas' => [
                'lomba' => $request->user()->level == 'admin' ? Lomba::all() : Lomba::where('status','1')->get(),
                'sekolah' => $request->user()->level == 'admin' ? Sekolah::all() : Sekolah::where('npsn', $request->user()->userable->sekolah_id)->get(),
                'guru' => $request->user()->level == 'admin' ? Guru::all() : Guru::where('id', $request->user()->userable_id)->get(),
                'bidang' => Bidang::all(),
                'peserta' => Peserta::all(),
                'juara' => Juara::all()
                ]
        ]);
    }

}

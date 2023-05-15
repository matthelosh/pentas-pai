<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class PesertaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // return 'Halo';
        try {
            // return auth()->user()->panitias[0]->guru;
            $page = auth()->user() ? 'Dashboard/' : '';
            if (auth()->check() && auth()->user()->level == 'panitia') {
                $pesertas = Peserta::where('sekolah_id', auth()->user()->panitias[0]->guru->sekolah_id)->with('sekolah','bidangs')->get();
            } else {
                $pesertas = Peserta::with('sekolah','bidangs')->get();
            }
            return Inertia::render($page.'Peserta',[
                'pesertas' => $pesertas,
                'bidangs' => Bidang::all()
            ], 200);
        } catch(\Exception $e) {
            return back()->withErrors(['msg' => $e->getMessage()]);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = json_decode($request->data);
            if ( $request->file('foto')) {
                $foto = $request->file('foto');
                $file = Storage::putFileAs('public/img/peserta', $foto, $data->nisn.'.jpg');
            }
            $bidangs = [];
            foreach($data->lomba_id as $kode) {
                $bidang = Bidang::where('kode', $kode)->select('id')->first();
                array_push($bidangs, $bidang->id);
            }
            $peserta = new Peserta();
            $peserta->nisn = $data->nisn;
            $peserta->nama = $data->nama;
            $peserta->jk = $data->jk;
            $peserta->foto = isset($file) ? '/storage/img/peserta/'.$data->nisn.'.jpg' : '';
            $peserta->hp = $data->hp;
            $peserta->lomba_id = implode(",", $data->lomba_id);
            $peserta->sekolah_id = $data->sekolah_id;
            $peserta->save();
            $peserta->bidangs()->attach($bidangs);
            return response()->json(['status' => 'ok', 'msg' => 'Peserta dalam proses pendaftaran'], 200);
        } catch(\Exception $e) {
            return response()->json(['status' => 'fail', 'msg' => $e->getMessage(), 'errCode' => $e->getCode()], 500);
        }
    }

    public function attach(Peserta $peserta, Request $request)
    {
        $pesertas = json_decode($request->pesertas);
        foreach($pesertas as $data) {
            $lombas = explode(",", $data->lomba_id);
            $bidangs = [];
            foreach($lombas as $kode) {
                $bidang = Bidang::where('kode', preg_replace('/\s+/', '', $kode))->select('id')->first();
                if($bidang !== null) {
                    array_push($bidangs, $bidang->id);
                }
            }

            $peserta = $peserta->where('id', $data->id)->with('bidangs')->first();
            if(count($peserta->bidangs) < 1) {
                $peserta->bidangs()->attach($bidangs);
            }
        }

        return response()->json(['status' => 'ok', 'msg' => 'Peserta dalam proses pendaftaran'], 200);
    }

    public function impor(Request $request)
    {
       try {
        foreach($request->data as $data) {
            Peserta::updateOrCreate(
                [
                    'nisn' => $data['nisn'] ?? null
                ],
                [
                    'nama' => $data['nama'],
                    'jk' => $data['jk'],
                    'sekolah_id' => $data['sekolah_id'],
                    'foto' => $data['foto'] ?? '/img/peserta.png',
                    'hp' => $data['hp'],
                    'lomba_id' => $data['lomba_id']
                ]
            );
            
        }
        return response()->json(['status' => 'ok', 'msg' => "Calon peserta disimpan"], 200);
       } catch(\Exception $e) {
        return response()->json(['status' => 'fail', 'msg' => $e->getMessage()], 500);
       }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            // dd(Peserta::find($id));
            // dd($request->file('foto'));
            $data = json_decode($request->data);
            if ( $request->file('foto')) {
                $foto = $request->file('foto');
                $file = Storage::putFileAs('public/img/peserta', $foto, $data->nisn.'.jpg');
            }
            $bidangs = [];
            foreach($data->lomba_id as $kode) {
                $bidang = Bidang::where('kode', $kode)->first();
                array_push($bidangs, $bidang->id);
            }
            $peserta = Peserta::find($id);
            // dd($peserta);
            $peserta->nisn = $data->nisn;
            $peserta->nama = $data->nama;
            $peserta->jk = $data->jk;
            $peserta->foto = isset($file) ? '/storage/img/peserta/'.$data->nisn.'.jpg' : '/img/peserta.png';
            $peserta->hp = $data->hp;
            $peserta->lomba_id = implode(",",$data->lomba_id);
            $peserta->sekolah_id = $data->sekolah_id;
            $peserta->save();
            if (count($peserta->bidangs) < count($bidangs)) {
                $peserta->bidangs()->attach($bidangs);
            }
            return response()->json(['status' => 'ok', 'msg' => 'Peserta dalam proses pendaftaran'], 200);
        } catch(\Exception $e) {
            return response()->json(['status' => 'fail', 'msg' => $e->getMessage(), 'errCode' => $e->getCode()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $peserta = Peserta::find($id);
            $peserta->bidangs()->detach();
            $peserta->delete();
            return 'OK';
        } catch(\Exception $e) {
            dd($e->getMEssage());
        }
    }
}

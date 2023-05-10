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
        try {
            $filter = $request->query('filter');
            // if(!$request->query('nisn')) {
            //     return Inertia::render('Peserta', [
            //         'pesertas' => Peserta::with('sekolah','bidang')->paginate(10),
            //     ]);
            // } else if($request->query('filter')) {
            //     return Inertia::render('Peserta', [
            //         'pesertas' => Peserta::where(['nama','LIKE','%'.$request->query('filter').'%'])->with('sekolah','bidang')->paginate(5),
            //     ]);
            // }
            // else {
            //     return response()->json(['peserta' => Peserta::where('nisn', $request->query('nisn'))->first()], 200);
            // }
            if ($filter) {
                // $pesertas =  DB::table('pesertas')->where('nama','like','%'.$filter.'%')->with('sekolah')->paginate(5);
                $pesertas = Peserta::where('nama','LIKE',"%{$filter}%")->with('sekolah', 'bidang')->paginate(10);
                return Inertia::render('Peserta', [
                    'pesertas' => $pesertas
                ]);
                // return $pesertas;
            } else {
                    return Inertia::render('Peserta', [
                    'pesertas' => Peserta::with('sekolah','bidang')->paginate(10),
                ]);
            }
            
            // return 
        } catch(\Exception $e) {

        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = json_decode($request->data);
            // dd($request->file('foto'));
            if ( $request->file('foto')) {
                $foto = $request->file('foto');
                $file = Storage::putFileAs('public/img/peserta', $foto, $data->nisn.'.jpg');
            }
            // dd($file);
            $bidangs = [];
            foreach($data->lomba_id as $kode) {
                $bidang = Bidang::where('kode', $kode)->select('id')->first();
                array_push($bidangs, $bidang->id);
            }
            // dd($bidangs);
            $peserta = new Peserta();
            $peserta->nisn = $data->nisn;
            $peserta->nama = $data->nama;
            $peserta->jk = $data->jk;
            $peserta->foto = isset($file) ? 'img/peserta/'.$data->nisn.'.jpg' : '';
            $peserta->hp = $data->hp;
            $peserta->lomba_id = implode(",", $data->lomba_id);
            $peserta->sekolah_id = $data->sekolah_id;
            $peserta->save();
            $peserta->bidangs()->attach($bidangs[0]);
            // Peserta::create(
            //     [
            //         'nisn' => $data->nisn,
            //         'nama' => $data->nama,
            //         'jk' => $data->jk,
            //         'sekolah_id' => $data->sekolah_id,
            //         'foto' => isset($file) ? 'img/peserta/'.$data->nisn.'.jpg' : '',
            //         'hp' => $data->hp,
            //         'lomba_id' => implode(",",$data->lomba_id)
            //     ]
            //     );
                response()->json(['status' => 'ok', 'msg' => 'Peserta dalam proses pendaftaran'], 200);
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
                $bidang = Bidang::where('kode', $kode)->select('id')->first();
                array_push($bidangs, $bidang->id);
            }

            // $peserta::findOrFail($data->id);
            $peserta->find($data->id)->bidangs()->attach($bidangs);
        }

        response()->json(['status' => 'ok', 'msg' => 'Peserta dalam proses pendaftaran'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Peserta $peserta, $id)
    {
        try {
            return response()->json(['status' => 'ok', 'peserta' => $peserta->where('nisn',$id)->first()], 200);
        } catch(\Exception $e) {

        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Peserta $peserta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Peserta $peserta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Peserta $peserta)
    {
        //
    }
}

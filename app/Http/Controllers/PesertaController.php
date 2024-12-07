<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\Lomba;
use App\Models\Peserta;
use Exception;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use PHPUnit\Event\Code\Throwable;

class PesertaController extends Controller
{


    public function lomba()
    {
        return Lomba::where('status', '1')->with('bidangs.pesertas')->first();
    }
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
                $pesertas = Peserta::where('sekolah_id', auth()->user()->userable->sekolah_id)->whereHas('lomba', function ($q) {
                    $q->where('lombas.status', '1');
                })->with('sekolah', 'bidangs', 'lomba')->get();
            } else {
                $pesertas = Peserta::with('bidangs', 'sekolah', 'lomba')->whereHas('lomba', function ($q) {
                    $q->where('lombas.status', '1');
                })->get();
            }
            return Inertia::render($page . 'Peserta', [
                'pesertas' => $pesertas,
                'lomba' => $this->lomba()
            ], 200);
        } catch (\Exception $e) {
            // return back()->with(['msg' => $e->getMessage()]);
            return Inertia::render('Errors', [
                'errors' => $e->getMEssage(),
            ]);
        }
    }

    public function getPeserta(Request $request)
    {
        try {
            $lomba = Lomba::whereStatus('1')->first();
            if ($request->query('bidang')) {
                // $pesertas = Peserta::where('lomba_id', 'LIKE', '%'.$request->query('bidang').'%')->with('sekolah','bidangs')->get();
                if ($request->user()->level == 'admin') {
                    $bidangId = $request->query('bidang');
                    $pesertas = Peserta::whereHas('bidangs', function ($q) use ($bidangId) {
                        $q->where('bidangs.id', $bidangId);
                    })
                        ->with('urutans', function ($u) use ($bidangId) {
                            $u->where('bidang_id', $bidangId);
                        })
                        ->with('bidangs', 'sekolah')->get();
                } else {
                    $bidangId = $request->query('bidang');
                    $pesertas = Peserta::where('sekolah_id', auth()->user()->userable->sekolah_id)->whereHas('bidangs', function ($q) use ($bidangId) {
                        $q->where('bidangs.id', $bidangId);
                    })->with('bidangs', 'sekolah')->get();
                }
            } else {
                $pesertas = Peserta::where('lomba_id', $lomba->id)->with('sekolah')->with('bidangs')->get();
            }
            return response()->json(['status' => 'ok', 'pesertas' => $pesertas], 200);
        } catch (\Exception $e) {
            // return response()->json(['status' => 'ok', 'msg' => $e->getMessage()], 500);
            dd($e);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $lomba = Lomba::where('status', '1')->first();
            $data = json_decode($request->data);
            if ($request->file('foto')) {
                $foto = $request->file('foto');
                // dd($foto);
                $file = Storage::putFileAs('public/img/peserta', $foto, $data->nisn . '.jpg');
            }
            $peserta = new Peserta();
            $peserta->nisn = $data->nisn;
            $peserta->nama = $data->nama;
            $peserta->jk = $data->jk;
            $peserta->foto = isset($file) ? '/storage/img/peserta/' . $data->nisn . '.jpg' : '';
            $peserta->hp = $data->hp;
            $bidangs = [];
            foreach ($data->bidangIds as $id) {
                $bidang = Bidang::find($id);
                $kode = explode("-", $bidang->kode);
                array_push($bidangs, $kode[1]);
            }
            $peserta->bidang_id = implode(",", $bidangs);
            $peserta->lomba_id = $lomba->id;
            $peserta->sekolah_id = $data->sekolah_id;
            $peserta->save();
            $peserta->bidangs()->attach($data->bidangIds);
            return response()->json(['status' => 'ok', 'msg' => 'Peserta dalam proses pendaftaran'], 200);
        } catch (\Exception $e) {
            dd($e);
            return response()->json(['status' => 'fail', 'msg' => $e->getMessage(), 'errCode' => $e->getCode()], 500);
        }
    }

    public function attach(Peserta $peserta, Request $request)
    {
        try {
            $lomba = Lomba::where('status', '1')->first();
            $lomba_id = $lomba->id;
            $pesertas = Peserta::where('lomba_id', $lomba->id)->whereDoesntHave('bidangs', function ($q) use ($lomba_id) {
                $q->where('lomba_id', $lomba_id);
            })->get();
            foreach ($pesertas as $peserta) {
                $bidangs = [];
                $kodes = explode(",", $peserta->bidang_id);
                foreach ($kodes as $kode) {
                    $tes = $lomba->kode . '-' . $kode . '-%-' . ($kode == 'lcc' || $kode == 'bjr' ? 'cr' : ($peserta->jk == 'Laki-laki' ? 'pa' : 'pi'));
                    $bidang = Bidang::where('kode', 'LIKE', $tes)->first();
                    if ($bidang !== null) {
                        array_push($bidangs, $bidang->id);
                    }
                }
                $peserta->bidangs()->attach($bidangs);
            }
            return response()->json(['status' => 'ok', 'msg' => 'Peserta didaftarkan berdasarkan bidang_id'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'msg' => $e->getMessage()], 500);
        }
    }

    public function impor(Request $request)
    {
        try {
            $lomba = Lomba::where('status', '1')->first();
            if (!$lomba) {
                throw new \Exception("Belum ada Lomba yang Aktif");
            }
            foreach ($request->data as $data) {
                $peserta = Peserta::updateOrCreate(
                    [
                        'nisn' => $data['nisn'] ?? null
                    ],
                    [
                        'nama' => $data['nama'],
                        'jk' => $data['jk'],
                        'sekolah_id' => $data['sekolah_id'],
                        'foto' => $data['foto'] ?? '/img/peserta.png',
                        'hp' => $data['hp'],
                        'lomba_id' => $lomba->id,
                        'bidang_id' => $data['bidangs']
                    ]
                );
            }
            return response()->json(['status' => 'ok', 'msg' => "Calon peserta disimpan"], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'msg' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $lomba = Lomba::where('status', '1')->first();
            $data = json_decode($request->data);
            $foto = $data->foto;
            if ($request->file('foto')) {
                $foto = $request->file('foto');
                // dd($foto);
                $delete = Storage::delete('public/img/peserta/' . $data->nisn . '.jpg');
                $store = Storage::putFileAs('public/img/peserta', $foto, $data->nisn . '.jpg');
                if ($store) {
                    $foto = Storage::url($store);
                }
            }
            $peserta = Peserta::find($id);
            $peserta->nisn = $data->nisn;
            $peserta->nama = $data->nama;
            $peserta->jk = $data->jk;
            $peserta->foto = $foto;
            $peserta->hp = $data->hp;
            $peserta->lomba_id = $lomba->id;
            $peserta->sekolah_id = $data->sekolah_id;
            // $bidangs = [];
            // foreach($data->bidangIds as $id) {
            //     $bidang = Bidang::find($id);
            //     $kode = explode("-",$bidang->kode);
            //     array_push($bidangs, $kode[1]);
            // }
            $peserta->save();
            $peserta->bidangs()->detach();
            $peserta->bidangs()->attach($data->bidangIds);
            return response()->json(['status' => 'ok', 'msg' => 'Peserta dalam proses pendaftaran'], 200);
        } catch (\Exception $e) {
            // return response()->json(['status' => 'fail', 'msg' => $e->getMessage(), 'errCode' => $e->getCode()], 500);
            dd($e);
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
        } catch (\Exception $e) {
            dd($e->getMEssage());
        }
    }
}

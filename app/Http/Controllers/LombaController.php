<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\Hasil;
use App\Models\Lomba;
use App\Models\Nilai;
use App\Models\Peserta;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LombaController extends Controller
{
    public function page(Request $request)
    {
        // dd($request->user()->level);
        if ($request->user()->level == 'admin') {
            $lombas = Lomba::with('sekolah', 'panitias')
                ->with([
                    'bidangs.pesertas',
                    'bidangs.aspeks',
                    'bidangs.juris.guru'
                ])
                ->get();
        } else {
            $user = $request->user();
            $guruId = $user->guru->id;
            if ($user->guru->has('juri')) {
                $lombas = Lomba::with('sekolah', 'panitias')
                    ->with([
                        'bidangs' => function ($b) use ($guruId) {
                            $b->where('bidangs.guru_id', $guruId);
                            $b->with('pesertas', 'aspeks', 'juris.guru');
                        }
                    ])
                    ->get();
            }
        }

        return Inertia::render('Dashboard/Lomba', [
            'lombas' => $lombas,
        ], 200);
    }

    public function activate(Request $request, $id)
    {
        Lomba::where('status', '1')->update(['status' => '0']);
        Lomba::find($id)->update(['status' => '1', 'lokasi_id' => $request->lokasi_id]);
        return response()->json(['status' => 'ok', 'msg' => 'Lomba diaktifkan'], 200);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->query('q') == 'select') {
            $lombas = Lomba::where('status', '1')->with('bidangs')->first();
        } else {
            $lombas = Lomba::where('status', '1')->with('bidangs.pesertas.sekolah')->get();
        }

        return response()->json(['status' => 'ok', 'lombas' => $lombas], 200);
    }

    public function rekap(Request $request)
    {
        // $datas = Sekolah::with('pesertas.bidangs')->get();
        if ($request->user()->level == 'admin') {
            $datas = Sekolah::with('pesertas.bidangs')->get();
        } else {
            $lombaId = Lomba::whereStatus('1')->value('id');
            $datas = Sekolah::where('npsn', auth()->user()->userable->sekolah_id)
                ->with(
                    [
                        'pesertas' => function ($p) use ($lombaId) {
                            $p->where('lomba_id', $lombaId);
                            $p->with('bidangs');
                        }
                    ]
                )->get();
        }
        return response()->json(['status' => 'ok', 'sekolahs' => $datas], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function formNilai(Request $request)
    {

        try {
            $lomba = Lomba::where('status', '1')->first();
            if ($request->user()->level == 'admin') {
                $bidangs = Bidang::where('lomba_id', $lomba->id)
                    ->with('lomba', 'aspeks.nilais')
                    ->with([
                        'pesertas' => function ($s) {
                            $s->with('sekolah');
                            $s->with('nilais');
                        }
                    ])
                    ->get();
            } else {
                $user = $request->user();
                // dd($user->userable);
                $guruId = $user->userable->id;
                if ($user->guru->has('juri')) {
                    $bidangs = Bidang::where('lomba_id', $lomba->id)
                        ->wherehas('juris', function ($j) use ($guruId) {
                            $j->where('juris.guru_id', $guruId);
                        })
                        ->with('lomba', 'aspeks.nilais')
                        ->with([
                            'pesertas' => function ($s) {
                                $s->with('sekolah');
                                $s->with('nilais');
                            }
                        ])
                        ->get();
                }
            }

            return Inertia::render(
                'Dashboard/FormNilai',
                [
                    'bidangs' => $bidangs
                ]
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function storeNilai(Request $request)
    {
        // dd($request->sekolah_id);
        try {
            if (!$request->sekolah_id) {
                foreach ($request->skors as $skor) {

                    $nilai = Nilai::updateOrCreate(
                        [
                            'id' => $skor['id'] ?? null,
                            'siswa_id' => $request->siswa_id,
                            'bidang_id' => $request->bidang_id,
                            'aspek_id' => $skor['aspek_id']
                        ],
                        [
                            'user_id' => $request->user()->id,
                            'nilai' => $skor['skor']
                        ]
                    );
                }
            } else {
                $bidang = $request->bidang_id;
                $pesertas = Peserta::whereHas('bidangs', function ($b) use ($bidang) {
                    $b->where('bidangs.id', $bidang);
                })->where('sekolah_id', $request->sekolah_id)->get();
                // dd($pesertas);
                foreach ($pesertas as $peserta) {
                    foreach ($request->skors as $skor) {
                        $nilai = Nilai::updateOrCreate(
                            [
                                'id' => $skor['id'] ?? null,
                                'siswa_id' => $peserta->nisn,
                                'bidang_id' => $request->bidang_id,
                                'aspek_id' => $skor['aspek_id']
                            ],
                            [
                                'user_id' => $request->user()->id,
                                'nilai' => $skor['skor']
                            ]
                        );
                    }
                }
            }

            return back()->with('message', 'Skor disimpan');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $lomba = json_decode($request->lomba);
            $simpan = Lomba::updateOrCreate(
                [
                    'id' => $lomba->id ?? null
                ],
                [
                    'kode' => $lomba->kode,
                    'label' => $lomba->label,
                    'tahun' => $lomba->tahun,
                    'tanggal' => $lomba->tanggal,
                    'lokasi_id' => $lomba->lokasi_id,
                    'status' => $lomba->status ?? '0'
                ]
            );

            // $simpan->bidangs()->attach($lomba->bidangs);
            if ($lomba->bidangs) {
                foreach ($lomba->bidangs as $bidang) {
                    Bidang::updateOrCreate(
                        ['id' => $bidang->id ?? null],
                        [
                            'lomba_id' => $lomba->id ?? $simpan->id,
                            'kode' => $bidang->kode,
                            'label' => $bidang->label . ' ' . ucfirst($bidang->kelompok),
                            'kategori' => $bidang->kategori,
                            'kelompok' => $bidang->kelompok,
                            'deskripsi' => $bidang->deskripsi
                        ]
                    );
                }
            }
            return response()->json([
                'status' => 'ok',
                'msg' => 'Data Lomba Disimpan'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'msg' => $e->getMessage(),
                'code' => $e->getCode()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function showResult(Request $request)
    {
        try {
            $bidangs = Bidang::whereLombaId($this->lomba()->id)
                ->with([
                    'results' => function ($r) {
                        $r->with('siswa.sekolah');
                        $r->with('siswa.nilais');
                        $r->orderBy('skor', 'DESC');
                    }
                ])
                ->with('aspeks', 'nilais')
                ->get();
            return Inertia::render(
                'Dashboard/HasilLomba',
                [
                    'bidangs' => $bidangs
                ]
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function storeResult(Request $request)
    {
        try {
            $datas = [];
            foreach ($request->nilais as $nilai) {
                $sum = 0;
                $skorCount = count($nilai['skors']);
                $sum = array_reduce($nilai['skors'], fn($s, $c) => $s + $c['skor'], 0);
                $hasil = Hasil::updateOrCreate(
                    [
                        'id' => $nilai['id'] ?? null,
                        'siswa_id' => $nilai['siswa_id'],
                        'user_id' => $request->user()->id,
                        'bidang_id' => $request->bidangId,
                    ],
                    [
                        'skor' => $sum / ($skorCount * 100) * 100
                    ]
                );

                array_push($datas, $hasil);
            }

            // dd($datas);
            return back()->with('message', $request->bidangId);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function frontHasil(Request $request)
    {
        try {
            $bidangs = Bidang::whereLombaId($this->lomba()->id)
                ->with('nilais', function ($n) {
                    $n->with('siswa', 'aspek');
                })->get();
            return Inertia::render(
                'Hasil',
                [
                    'bidangs' => $bidangs
                ]
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lomba $lomba)
    {
        //
    }

    public function lomba()
    {
        return Lomba::where('status', '1')->first();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Panitia;
use App\Models\Guru;
use App\Models\Lomba;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class PanitiaController extends Controller
{
    
    public function page()
    {
        return Inertia::render('Dashboard/Panitia', [
            'gurus' => Guru::with('sekolah', 'panitias.user')->get(),
        ], 200);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->user()->level == 'admin') {
            $panitias = Panitia::with('guru.sekolah','lomba')->get();
        } else {
            $panitias = Panitia::where('user_id', $request->user()->id)->with('guru.sekolah')->get();
        }
        return response()->json([
            'status' => 'Ok',
            'panitias' => $panitias
        ], 200);
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
        dd($data);
        try {
            $lomba = Lomba::where('tahun', date('Y'))->first();
            // dd($lomba);
            if($data->jabatan !== '0') {
                Panitia::updateOrCreate(
                    [
                        'id' => $data->id ?? null
                    ],
                    [
                        'jabatan' => $data->jabatan,
                        'guru_id' => $data->guru_id,
                        'lomba_id' => $data->lomba_id ?? $lomba->id, //Sementara
                        'user_id' => $data->user_id ?? $this->setUser($data->guru_id)
                    ]
                );
            } else {
                $panitia = Panitia::find($data->id);
                $panitia->delete();
            }
            return response()->json(['status' => 'ok', 'msg' => 'Panitia Disimpan'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'ok', 'msg' => $e->getMessage()], 500);
        }
    }

    public function setUser($guru_id)
    {
        $guru = Guru::where('id', $guru_id)->first();
        $nama = explode(",",$guru->nama);
        $user = new User();
        $i = rand(1,100);
        $user->name = str_replace([",","."," "],"", strtolower(strlen($nama[0]) >= 3 ? $nama[0] : $nama[1]));
        $user->email = $user->name.$i.'@kkgpaiwagir.or.id';
        $user->password = Hash::make('12345');
        $user->level = 'panitia';
        $user->save();

        return $user->id;
    }

    public function makeAccount()
    {
        try {
            $panitias = Panitia::all();
            foreach($panitias as $panitia) {
                Panitia::find($panitia->id)->update(['user_id' => $this->setUser($panitia->guru_id)]);
                // dd($this->setUser($panitia->guru_id));
            }

            return response()->json(['status' => 'ok', 'msg' => 'Akun Dibuat'], 200);
        } catch(\Exception $e) {
            return response()->json(['status' => 'fail', 'msg' => $e->getMessage()], 500);
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

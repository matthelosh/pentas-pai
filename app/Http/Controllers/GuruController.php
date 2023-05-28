<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{

    public function page(Request $request)
    {
        $gurus = $request->user()->level == 'admin' ? Guru::with('sekolah', 'user')->get() : Guru::where('nip', $request->user()->userable->nip)->with('sekolah','user')->get();
        return Inertia::render('Dashboard/Guru', [
            'gurus' => $gurus
        ], 200);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $gurus = Guru::all();
            return response()->json([
                'status' => 'ok',
                'gurus' => $gurus
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'msg' => $e->getMessage(),
                'code' => $e->getCode()
            ], 500);
        }
    }

    public function makeAccount(Request $request)
    {
        $user = $this->setUser($request->id);
        return response()->json(['status' => 'Ok', 'msg' => 'Guru dibuatkan akun User: '.$user->name ], 200);
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
        $user->userable_type = 'App\Models\Guru';
        $user->userable_id = $guru_id;
        $user->save();

        return $user;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function impor(Request $request)
    {
        try 
        {
            foreach(json_decode($request->gurus) as $guru)
            {
                Guru::updateOrCreate(
                    [
                        'id' => $guru->id ?? null,
                        'nip' => $guru->nip ?? uniqid()
                    ],
                    [
                        'nama'=> $guru->nama,
                        'jk'=> $guru->jk,
                        'alamat'=> $guru->alamat,
                        'hp'=> $guru->hp ?? '-',
                        'email'=> $guru->email ?? null,
                        'sekolah_id'=> $guru->sekolah_id ?? '0'
                    ]
                );
            }
            return response()->json([
                'status' => 'ok',
                'msg' => 'Data Guru Sukses Diimpor'
            ], 200);
        } catch(\Exception $e)
        {
            return response()->json([
                'status' => 'fail',
                'msg' => $e->getMessage(),
                'code' => $e->getCode(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Guru $guru)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guru $guru)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Guru $guru)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guru $guru)
    {
        //
    }
}

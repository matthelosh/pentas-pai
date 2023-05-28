<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ProfileController;
use App\Models\Bidang;
use App\Models\Lomba;
use App\Models\Peserta;
use App\Models\Sekolah;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

Route::inertia('/about', 'About')->name('about');

Route::prefix('lomba')->group(function() {
    Route::post('/', [LombaController::class, 'index'])->name('lomba.index');
});

Route::prefix('sekolah')->group(function() {
    
    Route::post('/', [SekolahController::class, 'index'])->name('front.sekolah.index');
    Route::post('/{id}', [SekolahController::class, 'show'])->name('sekolah.show');
});

Route::post('/registrasi', [PesertaController::class, 'store'])->name('peserta.store');

Route::prefix('daftar')->group(function() {
    Route::get('/', function() {
        $lomba = Lomba::where('status','1')->with('bidangs')->first();
        return Inertia::render('Daftar',
        [
            'sekolahs' => Sekolah::all(),
            'bidangs' => $lomba->bidangs,
        ]
    );
    })->name('daftar');
});

Route::prefix('peserta')->group(function() {
    
    Route::get('/', [PesertaController::class, 'index'])->name('peserta');
    Route::post('/{id}/detail', [PesertaController::class, 'show'])->name('peserta.show');
});

Route::prefix('verifikasi')->group(function() {
    Route::inertia('/', 'Verifikasi')->name('verifikasi');
    Route::get('/piagam', [JuaraController::class, 'verify'])->name('verifikasi.juara');
    Route::get('/{id}', [SertifikatController::class, 'verify'])->name('verifikasi.sertifikat');
});


Route::prefix('sekretariat')->middleware(['auth','verified'])->group(function () {
    Route::get('/', [DashController::class, 'index'])->name('dashboard');

    // Admin Sekolah
    Route::prefix('sekolah')->group(function() {
        Route::get('/', [SekolahController::class, 'home'])->name('sekolah.home');
        Route::post('/impor', [SekolahController::class, 'impor'])->name('sekolah.impor');
        Route::post('/', [SekolahController::class, 'index'])->name('sekolah.index');
    });

    Route::prefix('peserta')->group(function() {
        // Route::inertia('/', 'Dashboard/Peserta', [
        //     'pesertas' => Peserta::with('sekolah','bidangs')->get(),
        // ])->name('dashboard.peserta');
        Route::get('/', [PesertaController::class, 'index'])->name('dashboard.peserta');
        Route::post('/', [PesertaController::class, 'getPeserta'])->name('dashboard.peserta.index');
        Route::post('/attach', [PesertaController::class, 'attach'])->name('dashboard.peserta.attach');
        Route::post('/impor', [PesertaController::class, 'impor'])->name('dashboard.peserta.impor');
        Route::delete('/{id}', [PesertaController::class, 'destroy'])->name('dashboard.peserta.destroy');
        Route::post('/{id}', [PesertaController::class, 'update'])->name('dashboard.peserta.update');
    });

    Route::post('/bidang', function() {
        return response()->json(['bidangs' => Bidang::all()], 200);
    })->name('bidang.index');

    Route::prefix('panitia')->group(function() {
        Route::get('/', [PanitiaController::class, 'page'])->name('dashboard.panitia');
        Route::post('/', [PanitiaController::class, 'index'])->name('panitia.index');
        Route::post('/store', [PanitiaController::class, 'store'])->name('panitia.store');
        Route::post('/account/make', [PanitiaController::class, 'makeAccount'])->name('panitia.account.make');
    });

    Route::prefix('guru')->group(function() {
        Route::get('/', [GuruController::class, 'page'])->name('dashboard.guru');
        Route::post('/', [GuruController::class, 'index'])->name('guru.index');
        Route::post('/impor', [GuruController::class, 'impor'])->name('guru.impor');
        Route::post('/account/make', [GuruController::class, 'makeAccount'])->name('guru.account.make');
    });

    Route::prefix('lomba')->group(function() {
        Route::get('/', [LombaController::class, 'page'])->name('dashboard.lomba');
        Route::post('/', [LombaController::class, 'index'])->name('lomba.index');
        Route::post('/store', [LombaController::class, 'store'])->name('lomba.store');
        Route::put('/{id}', [LombaController::class, 'activate'])->name('lomba.activate');
    });

    Route::post('/rekap', [LombaController::class, 'rekap'])->name('rekap');
    Route::prefix('surat')->group(function() {
        Route::post('/', [SuratController::class, 'index'])->name('surat.index');
        Route::post('/store', [SuratController::class, 'store'])->name('surat.store');
        Route::post('/{id}/lampiran/store', [SuratController::class, 'storeAttachment'])->name('surat.lampiran.store');
    });

    Route::prefix('juara')->group(function() {
        Route::post('/', [JuaraController::class, 'index'])->name('juara.index');
        Route::post('/store', [JuaraController::class, 'store'])->name('juara.store');
        Route::post('/impor', [JuaraController::class, 'impor'])->name('juara.impor');
    });

    Route::prefix('administrasi')->group(function() {
        // Route::inertia('/', 'Dashboard/LazyAdministrasi')->name('administrasi');
        Route::inertia('/', 'Dashboard/Administrasi')->name('administrasi');
        // Route::get('/', [JuaraController::class, 'tes'])->name('administrasi');
    });
});

require __DIR__.'/auth.php';

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ProfileController;
use App\Models\Bidang;
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



Route::prefix('lomba')->group(function() {
    Route::post('/', [LombaController::class, 'index'])->name('lomba.index');
});

Route::prefix('sekolah')->group(function() {
    Route::post('/', [SekolahController::class, 'index'])->name('sekolah.index');
});

Route::post('/registrasi', [PesertaController::class, 'store'])->name('peserta.store');

Route::prefix('daftar')->group(function() {
    Route::get('/', function() {
        return Inertia::render('Daftar',
        [
            'sekolahs' => Sekolah::all(),
            'bidangs' => Bidang::all()
        ]
    );
    })->name('daftar');
});

Route::prefix('peserta')->group(function() {
    
    Route::get('/', [PesertaController::class, 'index'])->name('peserta');
    Route::get('/{id}/detail', [PesertaController::class, 'show'])->name('peserta.show');
});

Route::prefix('panitia')->middleware(['auth','verified'])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::prefix('peserta')->group(function() {
        Route::inertia('/', 'Dashboard/Peserta', [
            'pesertas' => Peserta::with('sekolah','bidangs')->get(),
        ])->name('dashboard.peserta');
        Route::post('/attach', [PesertaController::class, 'attach'])->name('dashboard.peserta.attach');
    });

    Route::prefix('surat')->group(function() {
        Route::post('/', [SuratController::class, 'index'])->name('surat.index');
        Route::post('/store', [SuratController::class, 'store'])->name('surat.store');
        Route::post('/{id}/lampiran/store', [SuratController::class, 'storeAttachment'])->name('surat.lampiran.store');
    });

    Route::prefix('administrasi')->group(function() {
        Route::inertia('/', 'Dashboard/Administrasi')->name('administrasi');
    });
});

require __DIR__.'/auth.php';

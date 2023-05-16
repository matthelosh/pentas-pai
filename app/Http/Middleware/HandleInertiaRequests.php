<?php

namespace App\Http\Middleware;

use App\Models\Lomba;
use App\Models\Panitia;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
            'lomba' => $this->lomba() ?? null,
            'sekolahs' => $request->user() ? $this->sekolahs($request->user()) : null,
        ]);
    }

    public function lomba()
    {
        return Lomba::where('tahun', date('Y'))->with('sekolah')->first();
    }

    public function sekolahs($user)
    {
        $sekolahs = [];
        if($user->level !== 'admin') {
            $panitia = Panitia::where('user_id', $user->id)->with('guru.sekolah')->first();
            array_push($sekolahs, $panitia->guru->sekolah);
        } else {
            $sekolahs = Panitia::all();
        }
        
        // $sekolahs = Sekolah::where('npsn', $panitia->guru->seklah_id)->get();
        return $sekolahs;
    }
}

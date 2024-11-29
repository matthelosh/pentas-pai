<?php

namespace App\Http\Middleware;

use App\Models\Lomba;
use App\Models\Panitia;
use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Env;
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
                'user' => $request->user() ? $this->user($request->user()) : null,
            ],
            'appEnv' => \config('app.env'),
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
            'flash' => [
                'message' => fn() => $request->session()->get('message')
            ],
            'lomba' => $this->lomba() ?? null,
            'sekolahs' => $request->user() ? $this->sekolahs($request->user()) : null,
            'panitias' => $request->user() ? $this->panitia() : null,
        ]);
    }


    public function lomba()
    {
        return Lomba::where('status', '1')->with('sekolah')->first();
    }

    public function sekolahs($user)
    {
        $sekolahs = [];
        if ($user->level !== 'admin') {
            $sekolah = Sekolah::where('npsn', $user->userable->sekolah_id)->first();
            array_push($sekolahs, $sekolah);
        } else {
            $sekolahs = Sekolah::all();
        }

        // $sekolahs = Sekolah::where('npsn', $panitia->guru->seklah_id)->get();
        return $sekolahs;
    }

    public function panitia()
    {
        return Panitia::where('lomba_id', $this->lomba()->id)->with('guru', 'jab')->get();
    }
    public function user($user)
    {
        return User::where('id', $user->id)->with('userable', 'panitias')->first();
    }
}

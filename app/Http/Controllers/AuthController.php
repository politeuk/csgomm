<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\User;

class AuthController extends Controller
{
    public function steam() {

        $rurl = Socialite::driver('steam')->redirect()->getTargetUrl();

        return Inertia::location($rurl);
    }

    public function callback() {
        $steam_user = Socialite::driver('steam')->user();

        // dd($steam_user);

        $user = User::updateOrCreate([
            'id' => $steam_user->id
        ], [
            'name' => $steam_user->nickname,
            'email' => "$steam_user->id@steamcommunity.com",
            'avatar' => $steam_user->user['avatarfull'],
        ]);

        Auth::login($user);

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function discord() {

        $this->middleware('auth');

        $rurl = Socialite::driver('discord')->redirect()->getTargetUrl();

        return Inertia::location($rurl);
    }

    public function discord_callback() {

        $this->middleware('auth');

        $discord_user = Socialite::driver('discord')->user();

        $exists = User::where('discord_id', $discord_user->user['id'])->first();

        if(!$exists || $exists->id == auth()->user()->id) {

            $user = User::where('id', auth()->user()->id)->update([
                'discord_id' => $discord_user->user['id'],
                'discord_access_token' => $discord_user->accessTokenResponseBody['access_token']
            ]);

            return Redirect::route('dashboard');
        }

        return redirect()->route('dashboard')->with('message', 'User already exists with that steam ID.');
    }
}

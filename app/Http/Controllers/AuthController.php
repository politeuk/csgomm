<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function steam() {

        $rurl = Socialite::driver('steam')->redirect()->getTargetUrl();

        return response('', 409)->header('X-Inertia-Location', $rurl);
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
}

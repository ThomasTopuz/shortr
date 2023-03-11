<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    //
    public function handleCallback()
    {
        $user = Socialite::driver('google')->stateless()->user();
        $existingUser = User::where('oAuthId', strval($user->id))->first();
        if ($existingUser) {
            Auth::login($existingUser);
        } else {
            $newUser = User::create([
                'name' => $user->name,
                'oAuthId' => strval($user->id),
                'email' => $user->email,
            ]);
            Auth::login($newUser);
        }
        return redirect()->to('/');
    }

    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }
}

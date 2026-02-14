<?php

namespace App\Http\Controllers\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;


class GoogleController extends Controller
{
    public function redirect() {
        return Socialite::driver('google')->redirect();
    }

    public function callback() {
        $GoogleUser = Socialite::driver('google')->stateless()->user();
        $user = User::whereEmail($GoogleUser->email)->first();
        if(!$user){
            $user = User::create(['name' => $GoogleUser->name, 'email' => $GoogleUser->email]);
        }
        Auth::login($user);
        return redirect('/dashboard');
    } 
}

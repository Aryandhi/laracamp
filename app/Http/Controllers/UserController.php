<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Auth;

class UserController extends Controller
{
    public function login() {
        return view('auth.user.login');
    }

    public function google() {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback() {
        $callback = Socialite::driver('google')->stateless()->user();
        $data = [
            'name'=> $callback->getName(),
            'email'=> $callback->getEmail(),
            'avatar'=> $callback->getAvatar(),
            'email_verified_at'=> date('Y-m-d H:i:s', time())
        ];

        // firstOrCreate for check email existing, when found same email system don't save data
        $user = User::firstOrCreate(['email' => $data['email']], $data);
        Auth::login($user, true); //process login

        return redirect(route('welcome'));
    }
}

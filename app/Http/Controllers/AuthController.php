<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $findUser = User::where('google_id', $user->id)->first();

            if ($findUser) {
                Auth::login($findUser);
                return redirect("/");
            } else {
                $newUser = User::create([
                    "name" => $user->name,
                    "email" => $user->email,
                    "google_id" => $user->id,
                    "password" => "dummypass",
                    "image" => $user->getAvatar(),
                ]);

                Auth::login($newUser, true);
                return redirect("/");
            }
        } catch (Exception $e) {
            return redirect("/")->with("error", "Unable to login!");
        }
    }

    public function logout(Request $request){
        Auth::logout();
        return redirect("/");
    }

    public function profile(Request $request){
        $user = User::where('id', Auth::user()->id)->with("fav", "article.header")->withCount("fav", "article")->first();
        return view('profile', compact('user'));
    }
}

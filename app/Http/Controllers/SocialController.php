<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

use Illuminate\Support\Facades\Auth;

use Exception;

use App\User;
class SocialController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
//        dd(Socialite::driver($provider)->user());
        $getInfo = Socialite::driver($provider)->user();
        $user = $this->createUser($getInfo,$provider);

        auth()->login($user);

        return redirect()->to('/'.$user->user_name);

    }
    function createUser($getInfo,$provider){
 $user = User::where('email', $getInfo->email)->first();

        if (!$user) {
            $username =$getInfo->email;
            $username = explode('@',$username);
            $user = User::create([
                'name'     => $getInfo->name,
                'email'    => $getInfo->email,
                'provider' => $provider,
                'is_verified' => '1',
                'user_name' => $username[0],
                'provider_id' => $getInfo->id
            ]);
        }
        return $user;
    }
}

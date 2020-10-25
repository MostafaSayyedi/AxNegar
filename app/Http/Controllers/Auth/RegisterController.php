<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MailController;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\User
     */
  /*  protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'verification_code' => sha1(time()),
        ]);
    }*/
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->sendEmailVerificationNotification();

        return $user;
    }
    public function register(Request $request)
    {
        request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $username= explode('@',$request->email);
        $username= $username[0];
        $user->user_name= $username;
        $user->password = Hash::make($request->password);
        $user->verification_code = sha1(time());
        $user->save();


        if ($user != null) {
            // dd($user->name, $user->email, $user->verification_code);
            MailController::sendSignupEmail($user->name, $user->email, $user->verification_code);
            return redirect('login')->with('success', 'لینک فعال سازی ایمیل برای شما ارسال شد.');
        }
        return back()->with('fail', 'خطا رخ داده است');

    }

    public function verifyUser(Request $request)
    {
        // dd($request);
        $verification_code= $request->get('code');
        $user= User::where('verification_code', $verification_code)->first();
        // dd($user);
        if ($user != null){
            $user->is_verified= 1;
            $user->save();
            return redirect('login')->with('success', 'ایمیل شما فعال شد.');
        }
        return redirect('login')->with('fail', 'خطا رخ داده است');
    }
}

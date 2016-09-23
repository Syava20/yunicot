<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use \App\User;

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
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($lockedOut = $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->credentials($request);
        $credentials['active'] = 1;
        $credentials['block'] = 0;
        if(\App\User::where('email', $credentials['email'])->first()['active'] == '0'){
            $errors[$this->username()] = Lang::get('auth.noactive');
            return $this->sendFailedLoginResponse($request, $errors);
        }
        elseif(\App\User::where('email', $credentials['email'])->first()['block'] == '1'){
            $errors[$this->username()] = Lang::get('auth.blocked');
            return $this->sendFailedLoginResponse($request, $errors);
        }

        if ($this->guard()->attempt($credentials, $request->has('remember'))) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if (! $lockedOut) {
            $this->incrementLoginAttempts($request);
        }
        $errors[$this->username()] = Lang::get('auth.failed');
        return $this->sendFailedLoginResponse($request, $errors);
    }

    protected function sendFailedLoginResponse(Request $request, $errors)
    {
        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors(
                $errors
            );
    }
}

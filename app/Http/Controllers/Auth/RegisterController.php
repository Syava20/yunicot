<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Support\Facades\Mail;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Lang;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstName' => 'required|max:50',
            'lastName' => 'required|max:50',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'sex' => 'required|in:0,1'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        $activationCode = str_random(32);
        while (User::where('activationCode', $activationCode)->count() > 0) {
            $activationCode = str_random(32);
        }

        Mail::send('emails.registration', array('code' => $activationCode), function ($message) use ($data) {
            $message->to($data['email'], $data['firstName'] . ' ' . $data['lastName'])->subject(Lang::get('activationMailSubject'));
        });

        return User::create([
            'firstName' => $data['firstName'],
            'lastName' => $data['lastName'],
            'email' => $data['email'],
            'sex' => $data['sex'],
            'password' => bcrypt($data['password']),
            'activationCode' => $activationCode,
        ]);
    }

    public function active($code)
    {
        $activeUser = User::where('activationCode', $code)->firstOrFail();
        $activeUser->active = 1;
        $activeUser->activationCode = '';
        $activeUser->save();
        return view('auth.active-success');
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        return redirect('/active');
    }

    public function send(){
        return view('auth.active');
    }
}

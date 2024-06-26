<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
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
    protected $redirectTo = '/dashboard';

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
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'number' => ['required', 'digits:11', 'regex:/^0/', 'unique:users' ],
        ],[
            'number.digits' => 'Phone number must be 11 digits',
            'number.regex' => 'Phone number must start with 0',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // return  User::create([
        //     'name' => $data['name'],
        //     'number' => $data['number'],
        //     'email' => $data['email'],
        //     'password' => Hash::make($data['password']),
        // ]);
            // Create a new user instance
    $user = new User([
        'name' => $data['name'],
        'number' => $data['number'],
        'email' => $data['email'],
        'role' => 'doctor',
        'password' => Hash::make($data['password']),
    ]);
    $user->save();
    $doctor = new Doctor;
    $doctor->user_id = $user->id;
    $doctor->save();
    return $user;

    }
}

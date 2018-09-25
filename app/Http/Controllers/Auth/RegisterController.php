<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
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
    protected $redirectTo = '/home';

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
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if ($data['full_name']) {
            $name = trim($data['full_name']);
            $data['surname'] = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
            $data['name'] = trim(preg_replace('#'.$data['surname'].'#', '', $name));
        }

        return Validator::make($data, [
            'name'     => 'required|string|min:2|max:255',
            'surname'  => 'required|string|min:2|max:255',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
    }

    public function showRegistrationForm(Request $request)
    {
        if (!session()->has('redirect')) {
            session()->put('redirect', $request->input('redirect', '/discover'));
        }

        return view('auth.register');
    }

    public function registered(Request $request, $user)
    {
        return redirect(session()->pull('redirect', session()->get('url.intended', $this->redirectTo)));
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     *
     * @return \App\User
     */
    protected function create(array $data)
    {
        if ($data['full_name']) {
            $name = trim($data['full_name']);
            $data['surname'] = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
            $data['name'] = trim(preg_replace('#'.$data['surname'].'#', '', $name));
        }

        return User::create([
            'name'     => $data['name'],
            'surname'  => $data['surname'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}

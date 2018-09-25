<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
    protected $redirectTo = '/discover';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm(Request $request)
    {
        if (!session()->has('redirect') && $request->has('redirect')) {
            session()->put('redirect', $request->input('redirect', '/discover'));
        } else {
            session()->forget('redirect');
        }

        return view('auth.login');
    }

    public function authenticated(Request $request, $user)
    {
        return redirect(session()->pull('redirect', session()->get('url.intended', $this->redirectTo)));
    }
}

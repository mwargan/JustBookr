<?php

namespace App\Http\Controllers;

use App\Models\FacebookLogin;
use App\Models\User;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Socialite;

class FacebookLoginsController extends Controller
{
    /**
     * Enforce middleware.
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['show', 'redirect', 'callback']]);
    }

    public function redirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback(Request $request)
    {
        if (!$request->input('code')) {
            if ($request->wantsJson()) {
                return response()->json(['errors' => ['email' => 'No Facebook']], 422);
            }

            return redirect('sign-up')->withErrors('Login failed: ' . $request->input('error') . ' - ' . $request->input('error_reason'));
        }
        $fbUser = Socialite::driver('facebook')->stateless()->fields([
            'name',
            'first_name',
            'last_name',
            'email',
            'verified',
        ])->user();
        $fbProvider = FacebookLogin::find($fbUser->getId());
        if ($fbProvider) {
            $user = User::find($fbProvider->{'user-id'});
        } else {
            if (!$fbUser->getEmail()) {
                if ($request->wantsJson()) {
                    return response()->json(['errors' => ['email' => 'No email provided from Facebook']], 422);
                }

                return redirect('sign-up')->withErrors('Login failed: Facebook did not provide an email');
            }
            $user = User::firstOrCreate(
                ['email' => $fbUser->getEmail()],
                ['name' => $fbUser->user['first_name'], 'surname' => $fbUser->user['last_name'], 'profilepic' => str_replace('type=normal', 'type=large', $fbUser->getAvatar()), 'password' => md5(microtime())]
            );
            if ($user->wasRecentlyCreated) {
                event(new Registered($user));
            }
            FacebookLogin::firstOrCreate(
                ['fb-user-id' => $fbUser->getId()],
                ['user-id' => $user->{'user-id'}, 'fb_name' => $fbUser->user['first_name'], 'fb_surname' => $fbUser->user['last_name'], 'fb_profilepic' => str_replace('type=normal', 'type=large', $fbUser->getAvatar()), 'fb_email' => $fbUser->user['email']]
            );
        }
        auth()->login($user, true);

        return redirect(session()->pull('redirect', session()->get('url.intended', 'discover')));
    }

    /**
     * Display a listing of the facebook logins.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $facebookLogins = FacebookLogin::with('user')->paginate(25);

        return view('facebook_logins.index', compact('facebookLogins'));
    }

    /**
     * Show the form for creating a new facebook login.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        $users = User::pluck('name', 'userid')->all();

        return view('facebook_logins.create', compact('users'));
    }

    /**
     * Store a new facebook login in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            $data = $this->getData($request);

            FacebookLogin::create($data);

            return redirect()->route('facebook_logins.facebook_login.index')
                ->with('success_message', 'Facebook Login was successfully added!');
        } catch (Exception $exception) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified facebook login.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $facebookLogin = FacebookLogin::with('user')->findOrFail($id);

        return view('facebook_logins.show', compact('facebookLogin'));
    }

    /**
     * Show the form for editing the specified facebook login.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $facebookLogin = FacebookLogin::findOrFail($id);
        $users = User::pluck('name', 'userid')->all();

        return view('facebook_logins.edit', compact('facebookLogin', 'users'));
    }

    /**
     * Update the specified facebook login in the storage.
     *
     * @param int                     $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        try {
            $data = $this->getData($request);

            $facebookLogin = FacebookLogin::findOrFail($id);
            $facebookLogin->update($data);

            return redirect()->route('facebook_logins.facebook_login.index')
                ->with('success_message', 'Facebook Login was successfully updated!');
        } catch (Exception $exception) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Remove the specified facebook login from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $facebookLogin = FacebookLogin::findOrFail($id);
            $facebookLogin->delete();

            return redirect()->route('facebook_logins.facebook_login.index')
                ->with('success_message', 'Facebook Login was successfully deleted!');
        } catch (Exception $exception) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Get the request's data from the request.
     *
     * @param Illuminate\Http\Request\Request $request
     *
     * @return array
     */
    protected function getData(Request $request)
    {
        $rules = [
            'fb-user-id'     => 'nullable',
            'syncprofilepic' => 'boolean',
            'fb_name'        => 'nullable|string|min:0|max:70',
            'fb_surname'     => 'nullable|string|min:0|max:70',
            'fb_email'       => 'nullable|string|min:0|max:90',
            'fb_gender'      => 'nullable|string|min:0|max:20',
            'fb_profilepic'  => 'nullable|string|min:0|max:259',
            'fb_link'        => 'nullable|string|min:0|max:59',
            'fb_location'    => 'nullable|string|min:0|max:59',
        ];

        $data = $request->validate($rules);

        $data['syncprofilepic'] = $request->has('syncprofilepic');

        return $data;
    }
}

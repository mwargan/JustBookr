<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\FacebookLogin;
use App\Models\User;
use Exception;
use ExceptionHelper;
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
        $this->middleware('auth:api', ['except' => ['show', 'redirect', 'callback']]);
    }

    public function redirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback(Request $request)
    {
        if (! $request->input('code')) {
            if ($request->wantsJson()) {
                return response()->json(['errors' => ['email' => 'No Facebook']], 422);
            }

            return redirect('sign-up')->withErrors('Login failed: '.$request->input('error').' - '.$request->input('error_reason'));
        }
        $fbUser = Socialite::driver('facebook')->stateless()->fields([
            'name',
            'first_name',
            'last_name',
            'email',
        ])->user();
        $fbProvider = FacebookLogin::find($fbUser->getId());
        if ($fbProvider) {
            $user = User::find($fbProvider->{'user-id'});
        } else {
            if (! $fbUser->getEmail()) {
                if ($request->wantsJson()) {
                    return response()->json(['errors' => ['email' => 'No email provided from Facebook']], 422);
                }

                return redirect('sign-up')->withErrors('Login failed: Facebook did not provide an email');
            }
            $user = User::firstOrCreate(
                ['email' => $fbUser->getEmail()], ['name' => $fbUser->user['first_name'], 'surname' => $fbUser->user['last_name'], 'profilepic' => str_replace('type=normal', 'type=large', $fbUser->getAvatar()), 'password' => md5(microtime())]
            );
            if ($user->wasRecentlyCreated) {
                event(new Registered($user));
            }
            FacebookLogin::firstOrCreate(
                ['fb-user-id' => $fbUser->getId()], ['user-id' => $user->{'user-id'}, 'fb_name' => $fbUser->user['first_name'], 'fb_surname' => $fbUser->user['last_name'], 'fb_profilepic' => str_replace('type=normal', 'type=large', $fbUser->getAvatar()), 'fb_email' => $fbUser->user['email']]
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
        return FacebookLogin::with('user')->paginate(25);
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

            return FacebookLogin::create($data);
        } catch (Exception $exception) {
            return ExceptionHelper::handleError($exception, $request);
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
        return FacebookLogin::with('user')->findOrFail($id);
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

            return $facebookLogin->update($data);
        } catch (Exception $exception) {
            return ExceptionHelper::handleError($exception, $request);
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

            return response()->json(['Resource deleted']);
        } catch (Exception $exception) {
            return ExceptionHelper::handleError($exception, $request);
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

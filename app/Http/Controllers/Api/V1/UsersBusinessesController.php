<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\UsersBusiness;
use Exception;
use ExceptionHelper;
use Illuminate\Http\Request;

class UsersBusinessesController extends Controller
{
    /**
     * Enforce middleware.
     */
    public function __construct()
    {
        $this->middleware(['auth:sanctum'], ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the users businesses.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        return UsersBusiness::with('business', 'user')->paginate(25);
    }

    /**
     * Store a new users business in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            $data = $this->getData($request);

            return UsersBusiness::create($data);
        } catch (Exception $exception) {
            return ExceptionHelper::handleError($exception, $request);
        }
    }

    /**
     * Display the specified users business.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        return UsersBusiness::with('business', 'user')->findOrFail($id);
    }

    /**
     * Update the specified users business in the storage.
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

            $usersBusiness = UsersBusiness::findOrFail($id);

            return $usersBusiness->update($data);
        } catch (Exception $exception) {
            return ExceptionHelper::handleError($exception, $request);
        }
    }

    /**
     * Remove the specified users business from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $usersBusiness = UsersBusiness::findOrFail($id);
            $usersBusiness->delete();

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
            'business_id' => 'nullable',
            'user_id'     => 'nullable',
            'is_admin'    => 'boolean|nullable',
            'is_active'   => 'boolean|nullable',

        ];

        $data = $request->validate($rules);

        $data['is_admin'] = $request->has('is_admin');
        $data['is_active'] = $request->has('is_active');

        return $data;
    }
}

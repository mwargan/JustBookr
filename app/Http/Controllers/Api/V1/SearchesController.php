<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Search;
use Exception;
use ExceptionHelper;
use Illuminate\Http\Request;

class SearchesController extends Controller
{
    /**
     * Enforce middleware.
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['store']]);
    }

    /**
     * Display a listing of the searches.
     *
     * @return Illuminate\View\View
     */
    public function index(Request $request)
    {
        $orderBy = $request['order_by'] ?? 'timestamp';
        $orderSort = $request['order_sort'] ?? 'desc';

        $paginate = $request['paginate'] ?? 'yes';
        $perPage = $request['per_page'] ?? '50';

        $user = $request['user'];
        $current_user = $request->user('api');

        $q = Search::orderBy($orderBy, $orderSort);

        if ($user && $current_user->can('listAllSearches', Search::class)) {
            $q = $q->where('user', '=', $user);
        } elseif ($current_user->canNot('listAllSearches', Search::class)) {
            $q = $q->where('user', '=', $current_user->{'user-id'});
        }

        if ($paginate === 'yes') {
            return $q->paginate($perPage);
        }

        return $q->get();
    }

    /**
     * Store a new search in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        //$this->authorize('create', Search::class);
        try {
            if (! $request['user'] && $request->user('api')) {
                $request['user'] = $request->user('api')->{'user-id'};
            }

            if (! $request['uni'] && $request->user('api')) {
                $request['uni'] = $request->user('api')->{'uni-id'};
            }

            $data = $this->getData($request);

            $post = Search::create($data);

            return $post;
        } catch (Exception $exception) {
            return ExceptionHelper::handleError($exception, $request);
        }
    }

    /**
     * Display the specified search.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show(Search $search)
    {
        $this->authorize('view', $search);

        return $search;
    }

    /**
     * Update the specified search in the storage.
     *
     * @param int                     $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update(Search $search, Request $request)
    {
        $this->authorize('update', $search);

        try {
            $data = $this->getData($request);

            $search->update($data);

            return $search;
        } catch (Exception $exception) {
            return ExceptionHelper::handleError($exception, $request);
        }
    }

    /**
     * Remove the specified search from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy(Search $search)
    {
        $this->authorize('forceDelete', $search);

        try {
            $search->delete();

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
            'query'         => 'required|string|min:1|max:100',
            'user'          => 'nullable|numeric|exists:users,user-id',
            'uni'           => 'nullable|numeric|exists:webometric_universities,uni-id',
            'results_count' => 'nullable|numeric|min:0',
        ];

        $data = $request->validate($rules);

        return $data;
    }
}

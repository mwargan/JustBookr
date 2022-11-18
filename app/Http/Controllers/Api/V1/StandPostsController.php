<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\StandPost;
use Exception;
use ExceptionHelper;
use Illuminate\Http\Request;

class StandPostsController extends Controller
{
    /**
     * Enforce middleware.
     */
    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'optimizeImages'], ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the stand posts.
     *
     * @return Illuminate\View\View
     */
    public function index(Request $request)
    {
        $orderBy = $request->input('order_by', 'created_at');
        $orderSort = $request['order_sort'] ?? 'desc';

        $paginate = $request['paginate'] ?? 'yes';
        $perPage = $request['per_page'] ?? '50';

        $available = $request['available'] ?? 'false';
        $active = $request['active'] ?? 'false';

        $uni = $request['university'];
        $stand = $request['stand'];
        $book = $request['isbn'];

        $q = Standpost::with('stand.business.users')->orderBy($orderBy, $orderSort);

        if ($available === 'true') {
            $q->available();
        }

        if ($uni) {
            $q->whereHas('stand', function ($q) use ($uni) {
                return $q->where('uni_id', '=', $uni);
            });
        }

        if ($stand) {
            $q->where('stand_id', '=', $stand);
        }

        if ($book) {
            $q->where('isbn', '=', $book);
        } else {
            $q->with('textbook');
        }

        if ($paginate === 'yes') {
            return $q->paginate($perPage);
        }

        return $q->get();
    }

    /**
     * Store a new stand post in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $request['is_active'] = 1;
        if (isset($request['post-description']) && !$request['description']) {
            $request['description'] = $request['post-description'];
        }
        $data = $this->getData($request);

        $this->authorize('create', [StandPost::class, $data['stand_id']]);

        try {
            $user = $request->user('api');

            $standPost = Standpost::create($data);

            return $standPost->load('textbook');
        } catch (Exception $exception) {
            return ExceptionHelper::handleError($exception, $request);
        }
    }

    /**
     * Display the specified stand post.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show(Request $request, Standpost $standPost)
    {
        return $standPost->load('stand.business');
    }

    /**
     * Activate the book.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function activate(StandPost $standPost, Request $request)
    {
        $this->authorize('general', $standPost);

        try {
            if ($standPost->is_active) {
                return $standPost;
            }
            $standPost->is_active = 1;
            $standPost->save();

            return $standPost;
        } catch (Exception $exception) {
            return ExceptionHelper::handleError($exception, $request);
        }
    }

    /**
     * Deactivate the stand.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function deactivate(StandPost $standPost, Request $request)
    {
        $this->authorize('general', $standPost);

        try {
            if (!$standPost->is_active) {
                return $standPost;
            }

            $standPost->is_active = 0;
            $standPost->save();

            return $standPost;
        } catch (Exception $exception) {
            return ExceptionHelper::handleError($exception, $request);
        }
    }

    /**
     * Update the specified stand post in the storage.
     *
     * @param int                     $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update(StandPost $standPost, Request $request)
    {
        $this->authorize('general', $standPost);

        try {
            $data['is_active'] = $standPost->is_active;

            $data = $this->getData($request);

            $standPost->update($data);

            return $standPost;
        } catch (Exception $exception) {
            return ExceptionHelper::handleError($exception, $request);
        }
    }

    /**
     * Remove the specified stand post from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy(StandPost $standPost)
    {
        $this->authorize('general', $standPost);

        try {
            $standPost->delete();

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
            'stand_id'    => 'exists:business_stands,id',
            'isbn'        => 'string|min:11|max:15|nullable',
            'description' => 'string|min:1|max:1000|nullable',
            'price'       => 'string|min:1|nullable',
            'is_active'   => 'boolean|nullable',

        ];

        $data = $request->validate($rules);

        $data['is_active'] = $request->has('is_active');

        return $data;
    }
}

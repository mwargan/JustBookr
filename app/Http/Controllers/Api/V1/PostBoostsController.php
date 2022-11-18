<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostBoost;
use Carbon\Carbon;
use Exception;
use ExceptionHelper;
use Illuminate\Http\Request;

class PostBoostsController extends Controller
{
    /**
     * Enforce middleware.
     */
    public function __construct()
    {
        $this->middleware(['auth:sanctum'], ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the post boosts.
     *
     * @return Illuminate\View\View
     */
    public function index(Request $request)
    {
        return PostBoost::with('post')->paginate(25);
    }

    /**
     * Store a new post boost in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $data = $this->getData($request);

        $post = Post::findOrFail($data['post_id']);

        $this->authorize('create', [PostBoost::class, $post]);

        try {
            $user = $request->user('api');

            if ($user->canNot('skipPayment', PostBoost::class)) {
                $price = $this->calculatePrice($post->price, $data['expires_at']);
                $user->charge($price);
            }

            $data['expires_at'] = Carbon::now()->addDays($data['expires_at']);

            $postBoost = PostBoost::create($data);

            return $postBoost;
        } catch (Exception $exception) {
            return ExceptionHelper::handleError($exception, $request);
        }
    }

    /**
     * Store a new post boost in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function getPrice(Request $request)
    {

        //Otherwise validator doesnt see url param
        $request['expires_at'] = request('expires_at', null);
        $request['post_id'] = request('post_id');

        if (request('duration')) {
            $request['expires_at'] = request('duration', null);
        }

        $data = $this->getData($request);

        $post = Post::findOrFail($data['post_id']);

        $this->authorize('create', [PostBoost::class, $post]);

        try {
            if ($data['expires_at']) {
                $price = $this->calculatePrice($post->price, $data['expires_at']);
            } else {
                $price = [];
                for ($k = 0; $k < 182; $k++) {
                    $price[] += $this->calculatePrice($post->price, $k);
                }
            }

            return response()->json(['price' => $price, 'can_skip_payment' => $request->user('api')->can('skipPayment', PostBoost::class)]);
        } catch (Exception $exception) {
            return ExceptionHelper::handleError($exception, $request);
        }
    }

    /**
     * Display the specified post boost.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show(PostBoost $postBoost, Request $request)
    {
        return $postBoost->load('post');
    }

    /**
     * Update the specified post boost in the storage.
     *
     * @param int                     $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update(PostBoost $postBoost, Request $request)
    {
        $this->authorize('update', $postBoost);

        try {
            $data = $this->getData($request);

            $postBoost->update($data);

            return $postBoost;
        } catch (Exception $exception) {
            return ExceptionHelper::handleError($exception, $request);
        }
    }

    /**
     * Remove the specified post boost from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy(PostBoost $postBoost, Request $request)
    {
        $this->authorize('delete', $postBoost);

        try {
            $postBoost->delete();

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
            'post_id'    => 'required|exists:posts,post-id',
            'expires_at' => 'nullable|integer|max:182|min:1',
        ];

        $data = $request->validate($rules);

        return $data;
    }

    /**
     * Get the request's data from the request.
     *
     * @param Illuminate\Http\Request\Request $request
     *
     * @return array
     */
    protected function calculatePrice($postPrice, $duration)
    {
        $price = (int) filter_var($postPrice, FILTER_SANITIZE_NUMBER_INT);

        $price = round(((log($price) / 13) * $duration) + 1.3, 0);

        //Convert to cents for Stripe
        $price = $price * 100;

        return $price;
    }
}

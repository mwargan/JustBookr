<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostComment;
use Exception;
use ExceptionHelper;
use Illuminate\Http\Request;

class PostCommentsController extends Controller
{
    /**
     * Enforce middleware.
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the post comments.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        return PostComment::with('post', 'user')->paginate(25);
    }

    /**
     * Store a new post comment in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            $data = $this->getData($request);

            return PostComment::create($data);
        } catch (Exception $exception) {
            return ExceptionHelper::handleError($exception, $request);
        }
    }

    /**
     * Display the specified post comment.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        return PostComment::with('post', 'user')->findOrFail($id);
    }

    /**
     * Update the specified post comment in the storage.
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

            $postComment = PostComment::findOrFail($id);

            return $postComment->update($data);
        } catch (Exception $exception) {
            return ExceptionHelper::handleError($exception, $request);
        }
    }

    /**
     * Remove the specified post comment from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $postComment = PostComment::findOrFail($id);
            $postComment->delete();

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
            'postid'            => 'required',
            'userid'            => 'required',
            'comment'           => 'required|string|min:1|max:250',
            'comment_timestamp' => 'required|date_format:j/n/Y g:i A',

        ];

        $data = $request->validate($rules);

        return $data;
    }
}

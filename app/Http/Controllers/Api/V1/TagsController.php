<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Exception;
use ExceptionHelper;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    /**
     * Enforce middleware.
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the tags.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $tags = Tag::paginate(25);
        if ($request->wantsJson()) {
            return response()->json(['tag' => $tags]);
        }

        return view('tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new tag.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        return view('tags.create');
    }

    /**
     * Store a new tag in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->authorize('create', Tag::class);

        try {
            $data = $this->getData($request);

            $tag = Tag::create($data);

            return response()->json(['tag' => $tag]);
        } catch (Exception $exception) {
            return ExceptionHelper::handleError($exception, $request);
        }
    }

    /**
     * Display the specified tag.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $tag = Tag::findOrFail($id);

        return response()->json(['tag' => $tag]);
    }

    /**
     * Show the form for editing the specified tag.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $tag = Tag::findOrFail($id);

        return view('tags.edit', compact('tag'));
    }

    /**
     * Update the specified tag in the storage.
     *
     * @param int                     $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update(Tag $tag, Request $request)
    {
        $this->authorize('update', $tag);

        try {
            $data = $this->getData($request);

            $tag->update($data);

            return response()->json(['tag' => $tag]);
        } catch (Exception $exception) {
            return ExceptionHelper::handleError($exception, $request);
        }
    }

    /**
     * Remove the specified tag from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy(Tag $tag)
    {
        $this->authorize('forceDelete', $tag);

        try {
            $tag->delete();

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
            't-data' => 'required|string|min:1|max:20',
            't-pic'  => 'nullable|string|min:0|max:159',
        ];

        $data = $request->validate($rules);

        return $data;
    }
}

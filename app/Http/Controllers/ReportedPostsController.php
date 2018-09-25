<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\ReportedPost;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class ReportedPostsController extends Controller
{
    /**
     * Enforce middleware.
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the reported posts.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $reportedPosts = ReportedPost::with('user', 'post')->paginate(25);

        return view('reported_posts.index', compact('reportedPosts'));
    }

    /**
     * Show the form for creating a new reported post.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        $users = User::pluck('name', 'user-id')->all();
        $posts = Post::pluck('user-id', 'post-id')->all();

        return view('reported_posts.create', compact('users', 'posts'));
    }

    /**
     * Store a new reported post in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            $data = $this->getData($request);

            ReportedPost::create($data);

            return redirect()->route('reported_posts.reported_post.index')
                ->with('success_message', 'Reported Post was successfully added!');
        } catch (Exception $exception) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified reported post.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $reportedPost = ReportedPost::with('user', 'post')->findOrFail($id);

        return view('reported_posts.show', compact('reportedPost'));
    }

    /**
     * Show the form for editing the specified reported post.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $reportedPost = ReportedPost::findOrFail($id);
        $users = User::pluck('name', 'user-id')->all();
        $posts = Post::pluck('user-id', 'post-id')->all();

        return view('reported_posts.edit', compact('reportedPost', 'users', 'posts'));
    }

    /**
     * Update the specified reported post in the storage.
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

            $reportedPost = ReportedPost::findOrFail($id);
            $reportedPost->update($data);

            return redirect()->route('reported_posts.reported_post.index')
                ->with('success_message', 'Reported Post was successfully updated!');
        } catch (Exception $exception) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => json_encode($exception->getMessage())]);
        }
    }

    /**
     * Remove the specified reported post from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $reportedPost = ReportedPost::findOrFail($id);
            $reportedPost->delete();

            return redirect()->route('reported_posts.reported_post.index')
                ->with('success_message', 'Reported Post was successfully deleted!');
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
            'reported_by' => 'nullable|exists:users,user-id',
            'post-id'     => 'nullable|exists:posts,post-id',
            'reason'      => 'nullable|string|min:0|max:150',
            'report_time' => 'nullable|date_format:j/n/Y g:i A',
            'resolved'    => 'nullable|numeric|min:-2147483648|max:2147483647',

        ];

        $data = $request->validate($rules);

        return $data;
    }
}

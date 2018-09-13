<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class PostCommentsController extends Controller {
/**
 * Enforce middleware.
 */
	public function __construct() {
		$this->middleware('auth:api', ['except' => ['index', 'show']]);
	}
	/**
	 * Display a listing of the post comments.
	 *
	 * @return Illuminate\View\View
	 */
	public function index() {
		$postComments = PostComment::with('post', 'user')->paginate(25);

		return view('post_comments.index', compact('postComments'));
	}

	/**
	 * Show the form for creating a new post comment.
	 *
	 * @return Illuminate\View\View
	 */
	public function create() {
		$posts = Post::pluck('userid', 'postid')->all();
		$users = User::pluck('name', 'userid')->all();

		return view('post_comments.create', compact('posts', 'users'));
	}

	/**
	 * Store a new post comment in the storage.
	 *
	 * @param Illuminate\Http\Request $request
	 *
	 * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
	 */
	public function store(Request $request) {
		try {

			$data = $this->getData($request);

			PostComment::create($data);

			return redirect()->route('post_comments.post_comment.index')
				->with('success_message', 'Post Comment was successfully added!');

		} catch (Exception $exception) {

			return back()->withInput()
				->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
		}
	}

	/**
	 * Display the specified post comment.
	 *
	 * @param int $id
	 *
	 * @return Illuminate\View\View
	 */
	public function show($id) {
		$postComment = PostComment::with('post', 'user')->findOrFail($id);

		return view('post_comments.show', compact('postComment'));
	}

	/**
	 * Show the form for editing the specified post comment.
	 *
	 * @param int $id
	 *
	 * @return Illuminate\View\View
	 */
	public function edit($id) {
		$postComment = PostComment::findOrFail($id);
		$posts = Post::pluck('userid', 'postid')->all();
		$users = User::pluck('name', 'userid')->all();

		return view('post_comments.edit', compact('postComment', 'posts', 'users'));
	}

	/**
	 * Update the specified post comment in the storage.
	 *
	 * @param  int $id
	 * @param Illuminate\Http\Request $request
	 *
	 * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
	 */
	public function update($id, Request $request) {
		try {

			$data = $this->getData($request);

			$postComment = PostComment::findOrFail($id);
			$postComment->update($data);

			return redirect()->route('post_comments.post_comment.index')
				->with('success_message', 'Post Comment was successfully updated!');

		} catch (Exception $exception) {

			return back()->withInput()
				->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
		}
	}

	/**
	 * Remove the specified post comment from the storage.
	 *
	 * @param  int $id
	 *
	 * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
	 */
	public function destroy($id) {
		try {
			$postComment = PostComment::findOrFail($id);
			$postComment->delete();

			return redirect()->route('post_comments.post_comment.index')
				->with('success_message', 'Post Comment was successfully deleted!');

		} catch (Exception $exception) {

			return back()->withInput()
				->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
		}
	}

	/**
	 * Get the request's data from the request.
	 *
	 * @param Illuminate\Http\Request\Request $request
	 * @return array
	 */
	protected function getData(Request $request) {
		$rules = [
			'postid' => 'required',
			'userid' => 'required',
			'comment' => 'required|string|min:1|max:250',
			'comment_timestamp' => 'required|date_format:j/n/Y g:i A',

		];

		$data = $request->validate($rules);

		return $data;
	}

}

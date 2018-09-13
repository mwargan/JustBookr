<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\ReportedPost;
use Exception;
use ExceptionHelper;
use Illuminate\Http\Request;

class ReportedPostsController extends Controller {
/**
 * Enforce middleware.
 */
	public function __construct() {
		$this->middleware('auth:api', ['except' => ['index', 'show']]);
	}
	/**
	 * Display a listing of the reported posts.
	 *
	 * @return Illuminate\View\View
	 */
	public function index() {
		return ReportedPost::with('user', 'post')->paginate(25);
	}

	/**
	 * Store a new reported post in the storage.
	 *
	 * @param Illuminate\Http\Request $request
	 *
	 * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
	 */
	public function store(Request $request) {
		try {

			$data = $this->getData($request);

			return ReportedPost::create($data);

		} catch (Exception $exception) {
			return ExceptionHelper::handleError($exception, $request);
		}
	}

	/**
	 * Display the specified reported post.
	 *
	 * @param int $id
	 *
	 * @return Illuminate\View\View
	 */
	public function show($id) {
		return ReportedPost::with('user', 'post')->findOrFail($id);
	}

	/**
	 * Update the specified reported post in the storage.
	 *
	 * @param  int $id
	 * @param Illuminate\Http\Request $request
	 *
	 * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
	 */
	public function update($id, Request $request) {
		try {

			$data = $this->getData($request);

			$reportedPost = ReportedPost::findOrFail($id);
			return $reportedPost->update($data);

		} catch (Exception $exception) {
			return ExceptionHelper::handleError($exception, $request);
		}
	}

	/**
	 * Remove the specified reported post from the storage.
	 *
	 * @param  int $id
	 *
	 * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
	 */
	public function destroy($id) {
		try {
			$reportedPost = ReportedPost::findOrFail($id);
			$reportedPost->delete();
			return response()->json(['Resource deleted']);

		} catch (Exception $exception) {
			return ExceptionHelper::handleError($exception, $request);
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
			'reported_by' => 'nullable|exists:users,user-id',
			'post-id' => 'nullable|exists:posts,post-id',
			'reason' => 'nullable|string|min:0|max:150',
			'report_time' => 'nullable|date_format:j/n/Y g:i A',
			'resolved' => 'nullable|numeric|min:-2147483648|max:2147483647',

		];

		$data = $request->validate($rules);

		return $data;
	}

}

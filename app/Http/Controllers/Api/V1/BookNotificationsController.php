<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\BookNotification;
use App\Models\User;
use Exception;
use ExceptionHelper;
use Illuminate\Http\Request;

class BookNotificationsController extends Controller {

/**
 * Enforce middleware.
 */
	public function __construct() {
		$this->middleware('auth:api');
	}
	/**
	 * Display a listing of the book notifications.
	 *
	 * @return Illuminate\View\View
	 */
	public function index(Request $request) {

		$orderBy = $request->input('order_by', 'created_at');
		$orderSort = $request['order_sort'] ?? 'desc';

		$paginate = $request['paginate'] ?? 'yes';
		$perPage = $request['per_page'] ?? '50';

		$uni = $request['university'];
		$user = $request['user'];
		$book = $request['isbn'];

		$q = BookNotification::orderBy($orderBy, $orderSort);

		if ($uni) {
			$q->where('uni_id', '=', $uni);
		}

		if ($user) {
			$q->where('user_id', '=', $user);
		}

		if ($book) {
			$q->where('isbn', '=', $book);
		}

		if ($paginate === 'yes') {
			return $q->paginate($perPage);
		}
		return $q->get();

	}

	/**
	 * Store a new post in the storage.
	 *
	 * @param Illuminate\Http\Request $request
	 *
	 * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
	 */
	public function store(Request $request) {
		$this->authorize('create', BookNotification::class);
		try {
			if (!$request['user_id']) {
				$request['user_id'] = $request->user()->{'user-id'};
			}

			if (!$request['uni_id']) {
				$request['uni_id'] = $request->user()->{'uni-id'};
			}

			$data = $this->getData($request);

			$post = BookNotification::create($data);

			return $post;

		} catch (Exception $exception) {

			return ExceptionHelper::handleError($exception, $request);

		}
	}

	/**
	 * Display the specified book notification.
	 *
	 * @param int $id
	 *
	 * @return Illuminate\View\View
	 */
	public function show(Request $request, BookNotification $bookNotification) {
		$this->authorize('view', $bookNotification);

		return $bookNotification->load('user', 'uni');

	}

	/**
	 * Remove the specified book notification from the storage.
	 *
	 * @param  int $id
	 *
	 * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
	 */
	public function destroy(Request $request, BookNotification $bookNotification) {
		$this->authorize('delete', $bookNotification);
		try {
			if ($request->user()->{'user-id'} !== $bookNotification->user_id) {
				return response()->json("Unauthorized", 403);
			}
			$bookNotification->delete();

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
			'user_id' => 'required|exists:users,user-id',
			'uni_id' => 'required|exists:webometric_universities,uni-id',
			'isbn' => 'required|digits:13|exists:textbooks,isbn',

		];

		$data = $request->validate($rules);

		return $data;
	}

}

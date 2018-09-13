<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\TextbookView;
use Exception;
use ExceptionHelper;
use Illuminate\Http\Request;

class TextbookViewsController extends Controller {
/**
 * Enforce middleware.
 */
	public function __construct() {
		$this->middleware('auth:api', ['except' => ['store']]);
	}
	/**
	 * Display a listing of the textbook views.
	 *
	 * @return Illuminate\View\View
	 */
	public function index(Request $request) {
		$orderBy = $request->input('order_by', 'tview-id');
		$orderSort = $request['order_sort'] ?? 'desc';

		$paginate = $request['paginate'] ?? 'yes';
		$perPage = $request['per_page'] ?? '50';

		$uni = $request['university'];
		$user = $request['user'];
		$book = $request['isbn'];
		$logged_in = $request['logged_in'];
		$current_user = $request->user('api');

		$q = TextbookView::orderBy($orderBy, $orderSort);

		if ($uni) {
			$q->where('uni-viewed', $uni);
		}

		if ($user && $current_user->can('listAllTextbookViews', TextbookView::class)) {
			$q = $q->where('user-id', $user);
		} elseif ($current_user->canNot('listAllTextbookViews', TextbookView::class)) {
			$q = $q->where('user-id', $current_user->{'user-id'});
		}

		if ($logged_in) {
			$q->where('user-id', '!=', null);
		}

		if ($book) {
			$q->where('isbn-viewed', $book);
		}

		if ($paginate === 'yes') {
			return $q->paginate($perPage);
		}

		return $q->get();

	}

	/**
	 * Store a new textbook view in the storage.
	 *
	 * @param Illuminate\Http\Request $request
	 *
	 * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
	 */
	public function store(Request $request, $isbn = null) {
		try {
			if ($isbn) {
				$request['isbn-viewed'] = $isbn;
			} elseif ($request['isbn']) {
				$request['isbn-viewed'] = $request['isbn'];
			}
			$request['view_IP'] = request()->ip();
			if ($request->user('api')) {
				$request['user-id'] = $request->user('api')->{'user-id'};
				$request['uni-viewed'] = $request->input('uni-viewed', $request->user('api')->{'uni-id'});
			} elseif ($request['uni-viewed']) {
				$request['uni-viewed'] = $request['uni-viewed'];
			}

			$data = $this->getData($request);

			$view = TextbookView::create($data);

			return $view;

		} catch (Exception $exception) {

			return ExceptionHelper::handleError($exception, $request);

		}
	}

	/**
	 * Display the specified textbook view.
	 *
	 * @param int $id
	 *
	 * @return Illuminate\View\View
	 */
	public function show(Request $request, TextbookView $textbookView) {
		$this->authorize('view', $textbookView);

		return $textbookView;

	}

	/**
	 * Remove the specified textbook view from the storage.
	 *
	 * @param  int $id
	 *
	 * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
	 */
	public function destroy(TextbookView $textbookView) {
		$this->authorize('forceDelete', $textbookView);
		try {
			$textbookView->delete();

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
			'user-id' => 'sometimes|nullable|numeric|exists:users,user-id',
			'view_IP' => 'sometimes|string|min:1|max:45',
			'isbn-viewed' => 'required|string|digits:13',
			'uni-viewed' => 'nullable|numeric|exists:webometric_universities,uni-id',
		];

		$data = $request->validate($rules);

		return $data;
	}

}

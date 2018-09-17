<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\BookAdded;
use App\Events\PostAdded;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Post;
use App\Models\Textbook;
use App\Models\User;
use Auth;
use Exception;
use ExceptionHelper;
use Illuminate\Http\Request;
use SearchHelper;

class PostsController extends Controller {

/**
 * Enforce middleware.
 */
	public function __construct() {
		$this->middleware(['auth:api', 'optimizeImages'], ['except' => ['index', 'show']]);
	}
	/**
	 * Display a listing of the posts.
	 *
	 * @return Illuminate\View\View
	 */
	public function index() {

		$q = Post::orderBy(request('order_by', 'date'), request('order_sort', 'desc'));

		$q->when(request('university'), function ($q, $university) {
			return $q->where('uni-id', $university);
		});

		$q->when(request('isbn'), function ($q, $isbn) {
			return $q->where('isbn', request('isbn'));
		}, function ($q) {
			return $q->with('textbook');
		});

		$q->when(request('title'), function ($q, $title) {
			return $q->whereHas('textbook', function ($q) use ($title) {
				return $q->where('book-title', 'LIKE', '%' . SearchHelper::stripStopWords($title) . '%');
			});
		});

		$q->when(request('available'), function ($q, $available) {
			return $q->available();
		});

		$q->when(request('active'), function ($q, $active) {
			return $q->active();
		});

		$q->when(request('boosted'), function ($q, $boosted) {
			return $q->whereHas('boosts');
		});

		$q->when(request('user'), function ($q, $user) {
			return $q->where('user-id', $user);
		}, function ($q) {
			$q->with('user');
		});

		$q->when(request('min_price'), function ($q, $min_price) {
			return $q->where('price', '>=', $min_price);
		});

		$q->when(request('max_price'), function ($q, $max_price) {
			return $q->where('price', '<=', $max_price);
		});

		if (request('paginate', true) === true) {
			return $q->paginate(request('per_page', 50));
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
		$request['user-id'] = Auth::user()->{'user-id'};

		if (!$request['uni-id']) {
			$request['uni-id'] = Auth::user()->{'uni-id'};
		}

		$data = $this->getData($request);

		$this->authorize('create', [Post::class, $data['isbn']]);

		try {
			if (!Textbook::whereIsbn($data['isbn'])->exists()) {
				$book_data = $this->getBookData($request);
				if (!isset($book_data['image-url'])) {
					$book_data['image-url'] = Textbook::uploadImage($data['isbn'], $request->file('image'));
				}
				$book = Textbook::create($book_data);
				event(new BookAdded($book));
			}

			$post = Post::create($data);
			event(new PostAdded($post));

			return $post->load('textbook');

		} catch (Exception $exception) {
			return ExceptionHelper::handleError($exception, $request);
		}
	}

	/**
	 * Display the specified post.
	 *
	 * @param int $id
	 *
	 * @return Illuminate\View\View
	 */
	public function show(Request $request, $id) {
		$q = Post::with('user', 'textbook', 'order')->withViews()->findOrFail($id);
		if ($q->order && $request->user('api')->canNot('view', [Order::class, $q->order])) {
			$q = $q->makeHidden('order');
		}
		return $q;
	}

	/**
	 * Update the specified post in the storage.
	 *
	 * @param  int $id
	 * @param Illuminate\Http\Request $request
	 *
	 * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
	 */
	public function update(Post $post, Request $request) {
		$this->authorize('update', $post);

		try {
			if (!$request['user-id']) {
				$request['user-id'] = Auth::user()->{'user-id'};
			}

			if (!$request['uni-id']) {
				$request['uni-id'] = Auth::user()->{'uni-id'};
			}

			$request['isbn'] = $post->isbn;

			$data = $this->getData($request);

			$post->update($data);

			return $post;

		} catch (Exception $exception) {
			return ExceptionHelper::handleError($exception, $request);
		}
	}

	/**
	 * markSold the specified post in the storage.
	 *
	 * @param  int $id
	 * @param Illuminate\Http\Request $request
	 *
	 * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
	 */
	public function markSold(Post $post, Request $request) {
		$this->authorize('markSold', $post);
		try {
			$post->status = 77;

			$post->save();

			return $post;

		} catch (Exception $exception) {
			return ExceptionHelper::handleError($exception, $request);
		}
	}

	/**
	 * markUnsold the specified post in the storage.
	 *
	 * @param  int $id
	 * @param Illuminate\Http\Request $request
	 *
	 * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
	 */
	public function markUnsold(Post $post, Request $request) {
		$this->authorize('markUnsold', $post);
		try {
			$post->status = 1;

			$post->save();

			return $post;

		} catch (Exception $exception) {
			return ExceptionHelper::handleError($exception, $request);
		}
	}

	/**
	 * Remove the specified post from the storage.
	 *
	 * @param  int $id
	 *
	 * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
	 */
	public function destroy(Post $post) {
		$this->authorize('forceDelete', $post);

		try {

			$post->delete();

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
			'user-id' => 'required|numeric|exists:users,user-id',
			'post-description' => 'required|string|min:10',
			'isbn' => 'required|numeric|digits:13',
			'uni-id' => 'required|numeric|exists:webometric_universities,uni-id',
			'price' => 'required|numeric|min:1|max:1000',
		];

		$data = $request->validate($rules);

		return $data;
	}

	/**
	 * Get the request's data from the request.
	 *
	 * @param Illuminate\Http\Request\Request $request
	 * @return array
	 */
	protected function getBookData(Request $request) {
		$rules = [

			'isbn' => 'required|numeric|digits:13|unique:textbooks,isbn,' . $request->isbn . ',isbn',
			'book-title' => 'required|string|min:5|max:259',
			'author' => 'required|string|min:5|max:259',
			'book-des' => 'nullable|sometimes|string',
			'edition' => 'nullable|string|min:1|max:64',
			'image-url' => 'required_without:image|url',
			'image' => 'required_without:image-url|image|max:20480',
		];

		$data = $request->validate($rules);

		return $data;
	}

}
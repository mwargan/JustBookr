<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Business;
use Exception;
use ExceptionHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BusinessesController extends Controller {

	/**
	 * Enforce middleware.
	 */
	public function __construct() {
		$this->middleware(['auth:api', 'optimizeImages'], ['except' => ['index', 'show']]);
	}
	/**
	 * Display a listing of the businesses.
	 *
	 * @return Illuminate\View\View
	 */

	public function index(Request $request) {
		$orderBy = $request->input('order_by', 'created_at');
		$orderSort = $request['order_sort'] ?? 'desc';

		$paginate = $request['paginate'] ?? 'yes';
		$perPage = $request['per_page'] ?? '50';

		$available = $request['available'] ?? 'false';
		$active = $request['active'] ?? 'false';

		$uni = $request['university'];
		$user = $request['user'];
		$stand = $request['stand'];
		$book = $request['isbn'];

		$q = Business::with('users')->orderBy($orderBy, $orderSort);

		$q->with(['stands' => function ($q) {
			return $q->active();
		}]);

		if ($available === 'true') {
			$q->available();
		}

		if ($uni) {
			$q->whereHas('stand', function ($q) use ($uni) {
				return $q->where('uni_id', '=', $uni);
			});
		}

		if ($user) {
			$q->whereHas('users', function ($q) use ($user) {
				return $q->where('user_id', $user);
			});
		}

		if ($paginate === 'yes') {
			return $q->paginate($perPage);
		}

		return $q->get();

	}

	/**
	 * Store a new business in the storage.
	 *
	 * @param Illuminate\Http\Request $request
	 *
	 * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
	 */

	public function store(Request $request) {
		$this->authorize('create', Business::class);
		try {

			$data = $this->getData($request);

			if (preg_match('/Bookr/i', $data['name']) != false) {
				return response()->json(['errors' => ['name' => 'The name can not contain the words "Bookr" or "JustBookr".']], 422);
			}
			$user = $request->user('api');

			if (!isset($data['logo'])) {
				if (!$request->hasFile('image') || !$request->file('image')->isValid()) {
					return response()->json(['errors' => ['image' => 'Your logo is not the correct format.']], 422);
				}
				$link = Storage::putFile('images/Uploads/businesses/' . urlencode($data['name']) . '/images/logos', $request->file('image'), 'public');
				$data['logo'] = Storage::url($link);
			}
			$post = $user->businesses()->create($data);
			$user->businessRoles()->create([
				'is_admin' => "1",
				'is_active' => "1",
				'business_id' => $post['id'],
			]);

			return $post;

		} catch (Exception $exception) {

			return ExceptionHelper::handleError($exception, $request);

		}
	}

	/**
	 * Display the specified business.
	 *
	 * @param int $id
	 *
	 * @return Illuminate\View\View
	 */

	public function show(Business $business, Request $request) {

		$business = $business->load('stands.posts.textbook');
		$business->load(['stands' => function ($q) {
			return $q->active()->with('university');
		}]);

		return $business;

	}

	/**
	 * Update the specified business in the storage.
	 *
	 * @param  int $id
	 * @param Illuminate\Http\Request $request
	 *
	 * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
	 */
	public function update(Business $business, Request $request) {
		$this->authorize('update', $business);
		try {

			$data = $this->getData($request);

			$business->update($data);

			return $business;

		} catch (Exception $exception) {

			return ExceptionHelper::handleError($exception, $request);

		}
	}

	/**
	 * Remove the specified business from the storage.
	 *
	 * @param  int $id
	 *
	 * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
	 */
	public function destroy(Business $business) {
		$this->authorize('delete', $business);
		try {

			$business->delete();

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
			'name' => 'string|min:3|max:255|unique:businesses,name',
			'description' => 'string|min:10|max:500|nullable',
			'website' => 'active_url|max:191|nullable',
			'logo' => 'required_without:image|active_url',
			'image' => 'required_without:logo|image|dimensions:min_width=128,min_height=128,max_width=1280,max_height=1280|between:100,1000',
		];

		$data = $request->validate($rules);

		return $data;
	}

}

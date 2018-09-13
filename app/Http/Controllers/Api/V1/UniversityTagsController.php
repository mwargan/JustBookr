<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\UniversityTag;
use Exception;
use ExceptionHelper;
use Illuminate\Http\Request;

class UniversityTagsController extends Controller {
/**
 * Enforce middleware.
 */
	public function __construct() {
		$this->middleware('auth:api', ['except' => ['index', 'show']]);
	}
	/**
	 * Display a listing of the university tags.
	 *
	 * @return Illuminate\View\View
	 */
	public function index() {
		return UniversityTag::paginate(25);
	}

	/**
	 * Store a new university tag in the storage.
	 *
	 * @param Illuminate\Http\Request $request
	 *
	 * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
	 */
	public function store(Request $request) {
		try {

			$data = $this->getData($request);

			return UniversityTag::create($data);

		} catch (Exception $exception) {
			return ExceptionHelper::handleError($exception, $request);
		}
	}

	/**
	 * Display the specified university tag.
	 *
	 * @param int $id
	 *
	 * @return Illuminate\View\View
	 */
	public function show($id) {
		return UniversityTag::findOrFail($id);
	}

	/**
	 * Update the specified university tag in the storage.
	 *
	 * @param  int $id
	 * @param Illuminate\Http\Request $request
	 *
	 * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
	 */
	public function update($id, Request $request) {
		try {

			$data = $this->getData($request);

			$universityTag = UniversityTag::findOrFail($id);
			return $universityTag->update($data);

		} catch (Exception $exception) {

			return ExceptionHelper::handleError($exception, $request);

		}
	}

	/**
	 * Remove the specified university tag from the storage.
	 *
	 * @param  int $id
	 *
	 * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
	 */
	public function destroy($id) {
		try {
			$universityTag = UniversityTag::findOrFail($id);
			$universityTag->delete();
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
			'uniid' => 'string|min:1|nullable',
			'tagid' => 'string|min:1|nullable',

		];

		$data = $request->validate($rules);

		return $data;
	}

}

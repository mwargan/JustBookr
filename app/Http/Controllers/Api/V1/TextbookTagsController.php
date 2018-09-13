<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Models\Textbook;
use App\Models\TextbookTag;
use Exception;
use ExceptionHelper;
use Illuminate\Http\Request;

class TextbookTagsController extends Controller {
/**
 * Enforce middleware.
 */
	public function __construct() {
		$this->middleware(['auth:api'], ['except' => ['index', 'show']]);
	}
	/**
	 * Display a listing of the textbook tags.
	 *
	 * @return Illuminate\View\View
	 */
	public function index() {
		return TextbookTag::with('tag', 'textbook')->paginate(25);
	}

	/**
	 * Store a new textbook tag in the storage.
	 *
	 * @param Illuminate\Http\Request $request
	 *
	 * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
	 */
	public function store(Request $request) {
		try {

			$data = $this->getData($request);

			return TextbookTag::create($data);

		} catch (Exception $exception) {
			return ExceptionHelper::handleError($exception, $request);

		}
	}

	/**
	 * Display the specified textbook tag.
	 *
	 * @param int $id
	 *
	 * @return Illuminate\View\View
	 */
	public function show($id) {
		return TextbookTag::with('tag', 'textbook')->findOrFail($id);
	}

	/**
	 * Update the specified textbook tag in the storage.
	 *
	 * @param  int $id
	 * @param Illuminate\Http\Request $request
	 *
	 * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
	 */
	public function update($id, Request $request) {
		try {

			$data = $this->getData($request);

			$textbookTag = TextbookTag::findOrFail($id);
			return $textbookTag->update($data);

		} catch (Exception $exception) {
			return ExceptionHelper::handleError($exception, $request);

		}
	}

	/**
	 * Remove the specified textbook tag from the storage.
	 *
	 * @param  int $id
	 *
	 * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
	 */
	public function destroy($id) {
		try {
			$textbookTag = TextbookTag::findOrFail($id);
			$textbookTag->delete();
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
			'tagid' => 'required',
			'isbn' => 'required|string|min:1|max:17',

		];

		$data = $request->validate($rules);

		return $data;
	}

}

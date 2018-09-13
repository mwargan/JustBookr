<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\User;
use App\Models\UsersBusiness;
use Exception;
use Illuminate\Http\Request;

class UsersBusinessesController extends Controller {

	/**
	 * Enforce middleware.
	 */
	public function __construct() {
		$this->middleware(['auth:api', 'optimizeImages'], ['except' => ['index', 'show']]);
	}

	/**
	 * Display a listing of the users businesses.
	 *
	 * @return Illuminate\View\View
	 */
	public function index() {
		$usersBusinesses = UsersBusiness::with('business', 'user')->paginate(25);

		return view('users_businesses.index', compact('usersBusinesses'));
	}

	/**
	 * Show the form for creating a new users business.
	 *
	 * @return Illuminate\View\View
	 */
	public function create() {
		$businesses = Business::pluck('name', 'id')->all();
		$users = User::pluck('name', 'user-id')->all();

		return view('users_businesses.create', compact('businesses', 'users'));
	}

	/**
	 * Store a new users business in the storage.
	 *
	 * @param Illuminate\Http\Request $request
	 *
	 * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
	 */
	public function store(Request $request) {
		try {

			$data = $this->getData($request);

			UsersBusiness::create($data);

			return redirect()->route('users_businesses.users_business.index')
				->with('success_message', 'Users Business was successfully added!');

		} catch (Exception $exception) {

			return back()->withInput()
				->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
		}
	}

	/**
	 * Display the specified users business.
	 *
	 * @param int $id
	 *
	 * @return Illuminate\View\View
	 */
	public function show($id) {
		$usersBusiness = UsersBusiness::with('business', 'user')->findOrFail($id);

		return view('users_businesses.show', compact('usersBusiness'));
	}

	/**
	 * Show the form for editing the specified users business.
	 *
	 * @param int $id
	 *
	 * @return Illuminate\View\View
	 */
	public function edit($id) {
		$usersBusiness = UsersBusiness::findOrFail($id);
		$businesses = Business::pluck('name', 'id')->all();
		$users = User::pluck('name', 'user-id')->all();

		return view('users_businesses.edit', compact('usersBusiness', 'businesses', 'users'));
	}

	/**
	 * Update the specified users business in the storage.
	 *
	 * @param  int $id
	 * @param Illuminate\Http\Request $request
	 *
	 * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
	 */
	public function update($id, Request $request) {
		try {

			$data = $this->getData($request);

			$usersBusiness = UsersBusiness::findOrFail($id);
			$usersBusiness->update($data);

			return redirect()->route('users_businesses.users_business.index')
				->with('success_message', 'Users Business was successfully updated!');

		} catch (Exception $exception) {

			return back()->withInput()
				->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
		}
	}

	/**
	 * Remove the specified users business from the storage.
	 *
	 * @param  int $id
	 *
	 * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
	 */
	public function destroy($id) {
		try {
			$usersBusiness = UsersBusiness::findOrFail($id);
			$usersBusiness->delete();

			return redirect()->route('users_businesses.users_business.index')
				->with('success_message', 'Users Business was successfully deleted!');

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
			'business_id' => 'nullable',
			'user_id' => 'nullable',
			'is_admin' => 'boolean|nullable',
			'is_active' => 'boolean|nullable',

		];

		$data = $request->validate($rules);

		$data['is_admin'] = $request->has('is_admin');
		$data['is_active'] = $request->has('is_active');

		return $data;
	}

}

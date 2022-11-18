<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Exception;
use ExceptionHelper;
use Illuminate\Http\Request;

class CountriesController extends Controller
{
    /**
     * Enforce middleware.
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the countries.
     *
     * @return Illuminate\View\View
     */
    public function index(Request $request)
    {
        $q = Country::withCount('universities');
        $q->when(request('name'), function ($q, $name) {
            return $q->where('name', 'LIKE', '%' . $name . '%');
        });

        if (request('paginate', true) === true) {
            return $q->paginate(request('per_page', 50));
        }

        return $q->get();
    }

    /**
     * Display the specified country.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show(Request $request, Country $country)
    {
        return $country->load(['universities' => function ($query) {
            $query->count();
        }]);
    }

    /**
     * Store a new University in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->authorize('create', Country::class);

        try {
            $data = $this->getData($request);

            $country = Country::create($data);

            return $country;
        } catch (Exception $exception) {
            return ExceptionHelper::handleError($exception, $request);
        }
    }

    /**
     * Update the specified country in the storage.
     *
     * @param int                     $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update(Country $country, Request $request)
    {
        $this->authorize('update', $country);

        try {
            $data = $this->getData($request);

            $country->update($data);

            return $country;
        } catch (Exception $exception) {
            return ExceptionHelper::handleError($exception, $request);
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
            'iso2'         => 'required|string|size:2|unique:countries,iso2,' . request('iso2') . ',iso2',
            'iso3'         => 'required|string|size:3|unique:countries,iso3,' . request('iso2') . ',iso2',
            'name'         => 'required|string|min:1|max:100|unique:countries,name,' . request('iso2') . ',iso2',
            'currency'     => 'nullable|string|min:0|max:7',
            'currency_iso' => 'nullable|string|size:3',

        ];

        $data = $request->validate($rules);

        return $data;
    }
}

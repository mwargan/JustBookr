<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\University;
use DB;
use Exception;
use ExceptionHelper;
use Illuminate\Http\Request;

class UniversitiesController extends Controller
{
    /**
     * Enforce middleware.
     */
    public function __construct()
    {
        $this->middleware(['auth:api', 'optimizeImages'], ['except' => ['index', 'show', 'views']]);
    }

    /**
     * Display a listing of the Universities.
     *
     * @return Illuminate\View\View
     */
    public function index(Request $request)
    {
        $orderBy = $request['order_by'] ?? 'users_count';
        $orderSort = $request['order_sort'] ?? 'desc';

        $paginate = $request['paginate'] ?? 'yes';
        $perPage = $request['per_page'] ?? '25';

        $active = $request['active'] ?? 'false';

        $logo = $request['with_logo'] ?? 'false';

        $country_id = $request['country_id'];

        $country = $request['country'];

        $q = University::withCount('users')->orderBy($orderBy, $orderSort)->with('country');

        if ($active === 'true') {
            $q = $q->active();
        }

        if ($country_id) {
            $q = $q->where('country_id', '=', $uni);
        }

        if ($logo === 'true') {
            $q = $q->where('uni-logo', '!=', null);
        }

        if ($country) {
            $country = Country::findOrFail($country);
            $q = $q->where('country_id', '=', $country->id);
        }

        if ($paginate === 'yes') {
            return $q->paginate($perPage);
        }

        return $q->get();
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
        $this->authorize('create', University::class);

        try {

            //Without this error returns undefined index
            $request['uni-logo'] = $request->input('uni-logo', null);

            $data = $this->getData($request);

            $University = University::create($data);

            return response()->json(['university' => $University]);
        } catch (Exception $exception) {
            return ExceptionHelper::handleError($exception, $request);
        }
    }

    /**
     * Display the specified University.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show(Request $request, $id)
    {
        $University = University::with('country')->findOrFail($id);

        return $University;
    }

    /**
     * Display the specified textbook.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function views(Request $request, $id)
    {
        //->whereRaw('`date-viewed` >= DATE_SUB(NOW(),INTERVAL 1 YEAR)')
        $q = University::findOrFail($id)->bookViews()->selectRaw('MONTH(`date-viewed`) as month, count(*) as score')->groupBy(DB::raw('month'))->distinct();

        if ($request['past_year']) {
            $q->whereRaw('`date-viewed` >= DATE_SUB(NOW(),INTERVAL 1 YEAR)');
        }
        $textbook = $q->get();

        return $textbook;
    }

    /**
     * Update the specified University in the storage.
     *
     * @param int                     $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update(University $university, Request $request)
    {
        $this->authorize('update', $university);

        try {
            $data = $this->getData($request);

            return $data;

            $university->update($data);

            return response()->json(['university' => $university]);
        } catch (Exception $exception) {
            return ExceptionHelper::handleError($exception, $request);
        }
    }

    /**
     * Remove the specified University from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy(University $university)
    {
        $this->authorize('forceDelete', $university);

        try {
            $university->delete();
            return response()->json(['Resource deleted']);
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
            'uni-name' => 'required|string|min:1|max:150',
            'en-name' => 'nullable|string|max:150',
            'abr' => 'nullable|string|max:64',
            'country_id' => 'required|numeric|exists:countries,id',
            'city' => 'nullable|string|max:64',
            'address' => 'nullable|string|max:259',
            'description' => 'nullable',
            'uni-tel' => 'nullable|string|max:59',
            'uni-pic' => 'nullable|url|max:259',
            'uni-logo' => 'nullable|url|max:259',
            'uni-lat' => 'nullable|numeric|min:-9999.999999|max:9999.999999',
            'uni-lon' => 'nullable|numeric|min:-9999.999999|max:9999.999999',
            'url' => 'nullable|url',
        ];
        $data = $request->validate($rules);

        return $data;
    }
}

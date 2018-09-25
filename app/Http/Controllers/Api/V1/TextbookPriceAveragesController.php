<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\TextbookPriceAverage;

class TextbookPriceAveragesController extends Controller
{
    /**
     * Enforce middleware.
     */
    public function __construct()
    {
        $this->middleware(['auth:api'], ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the textbook price averages.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        return TextbookPriceAverage::paginate(25);
    }

    /**
     * Display the specified textbook price average.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        return TextbookPriceAverage::findOrFail($id);
    }
}

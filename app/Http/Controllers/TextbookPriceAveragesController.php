<?php

namespace App\Http\Controllers;

use App\Models\TextbookPriceAverage;
use Illuminate\Http\Request;

class TextbookPriceAveragesController extends Controller
{
    /**
     * Enforce middleware.
     */
    public function __construct()
    {
        $this->middleware(['auth:sanctum'], ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the textbook price averages.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $textbookPriceAverages = TextbookPriceAverage::paginate(25);

        return view('textbook_price_averages.index', compact('textbookPriceAverages'));
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
        $textbookPriceAverage = TextbookPriceAverage::findOrFail($id);

        return view('textbook_price_averages.show', compact('textbookPriceAverage'));
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
            'isbn'   => 'string|min:1|nullable',
            'uni-id' => 'string|min:1|nullable',
            'min'    => 'string|min:1|nullable',
            'avg'    => 'string|min:1|nullable',
            'max'    => 'string|min:1|nullable',

        ];

        $data = $request->validate($rules);

        return $data;
    }
}

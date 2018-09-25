<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Point;

class PointsController extends Controller
{
    /**
     * Enforce middleware.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the points.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        return Point::with('user')->paginate(25);
    }

    /**
     * Display the specified point.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        return Point::with('user')->findOrFail($id);
    }
}

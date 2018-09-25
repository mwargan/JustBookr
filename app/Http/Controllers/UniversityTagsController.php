<?php

namespace App\Http\Controllers;

use App\Models\UniversityTag;
use Exception;
use Illuminate\Http\Request;

class UniversityTagsController extends Controller
{
    /**
     * Enforce middleware.
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the university tags.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $universityTags = UniversityTag::paginate(25);

        return view('university_tags.index', compact('universityTags'));
    }

    /**
     * Show the form for creating a new university tag.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        return view('university_tags.create');
    }

    /**
     * Store a new university tag in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            $data = $this->getData($request);

            UniversityTag::create($data);

            return redirect()->route('university_tags.university_tag.index')
                ->with('success_message', 'University Tag was successfully added!');
        } catch (Exception $exception) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified university tag.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $universityTag = UniversityTag::findOrFail($id);

        return view('university_tags.show', compact('universityTag'));
    }

    /**
     * Show the form for editing the specified university tag.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $universityTag = UniversityTag::findOrFail($id);

        return view('university_tags.edit', compact('universityTag'));
    }

    /**
     * Update the specified university tag in the storage.
     *
     * @param int                     $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        try {
            $data = $this->getData($request);

            $universityTag = UniversityTag::findOrFail($id);
            $universityTag->update($data);

            return redirect()->route('university_tags.university_tag.index')
                ->with('success_message', 'University Tag was successfully updated!');
        } catch (Exception $exception) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Remove the specified university tag from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $universityTag = UniversityTag::findOrFail($id);
            $universityTag->delete();

            return redirect()->route('university_tags.university_tag.index')
                ->with('success_message', 'University Tag was successfully deleted!');
        } catch (Exception $exception) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
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
            'uniid' => 'string|min:1|nullable',
            'tagid' => 'string|min:1|nullable',

        ];

        $data = $request->validate($rules);

        return $data;
    }
}

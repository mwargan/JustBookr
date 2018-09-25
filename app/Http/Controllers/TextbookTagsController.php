<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Textbook;
use App\Models\TextbookTag;
use Exception;
use Illuminate\Http\Request;

class TextbookTagsController extends Controller
{
    /**
     * Display a listing of the textbook tags.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $textbookTags = TextbookTag::with('tag', 'textbook')->paginate(25);

        return view('textbook_tags.index', compact('textbookTags'));
    }

    /**
     * Show the form for creating a new textbook tag.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        $tags = Tag::pluck('tdata', 'tagid')->all();
        $textbooks = Textbook::pluck('booktitle', 'isbn')->all();

        return view('textbook_tags.create', compact('tags', 'textbooks'));
    }

    /**
     * Store a new textbook tag in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            $data = $this->getData($request);

            TextbookTag::create($data);

            return redirect()->route('textbook_tags.textbook_tag.index')
                ->with('success_message', 'Textbook Tag was successfully added!');
        } catch (Exception $exception) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified textbook tag.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $textbookTag = TextbookTag::with('tag', 'textbook')->findOrFail($id);

        return view('textbook_tags.show', compact('textbookTag'));
    }

    /**
     * Show the form for editing the specified textbook tag.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $textbookTag = TextbookTag::findOrFail($id);
        $tags = Tag::pluck('tdata', 'tagid')->all();
        $textbooks = Textbook::pluck('booktitle', 'isbn')->all();

        return view('textbook_tags.edit', compact('textbookTag', 'tags', 'textbooks'));
    }

    /**
     * Update the specified textbook tag in the storage.
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

            $textbookTag = TextbookTag::findOrFail($id);
            $textbookTag->update($data);

            return redirect()->route('textbook_tags.textbook_tag.index')
                ->with('success_message', 'Textbook Tag was successfully updated!');
        } catch (Exception $exception) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Remove the specified textbook tag from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $textbookTag = TextbookTag::findOrFail($id);
            $textbookTag->delete();

            return redirect()->route('textbook_tags.textbook_tag.index')
                ->with('success_message', 'Textbook Tag was successfully deleted!');
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
            'tagid' => 'required',
            'isbn'  => 'required|string|min:1|max:17',

        ];

        $data = $request->validate($rules);

        return $data;
    }
}

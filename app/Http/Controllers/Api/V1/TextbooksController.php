<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\BookAdded;
use App\Http\Controllers\Controller;
use App\Models\Textbook;
use App\Models\TextbookView;
use DB;
use Exception;
use ExceptionHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TextbooksController extends Controller
{
    /**
     * Enforce middleware.
     */
    public function __construct()
    {
        $this->middleware(['auth:api', 'optimizeImages'], ['except' => ['index', 'show', 'views']]);
    }

    /**
     * Display a listing of the textbooks.
     *
     * @return Illuminate\View\View
     */
    public function index(Request $request)
    {
        $available = $request['available'] ?? 'false';
        $active = $request['active'] ?? 'false';

        $uni = $request['university'];

        $q = Textbook::withCount('posts', 'purchases')->orderBy(request('order_by', 'posts_count'), request('order_sort', 'desc'));

        if ($active === 'true' || $available === 'true' || $uni) {
            $q->whereHas('posts', function ($q) use ($uni, $active, $available) {
                if ($uni) {
                    $q->where('uni-id', '=', $uni);
                }

                if ($available === 'true') {
                    $q->available();
                }

                if ($active === 'true') {
                    $q->active();
                }
            });
        }

        $q->when(request('title'), function ($q, $title) {
            return $q->whereRaw('`book-title` LIKE ?', ['%'.SearchHelper::stripStopWords($title).'%']);
        });
        $q->when(request('author'), function ($q, $author) {
            return $q->whereRaw('`author` LIKE ?', ['%'.SearchHelper::stripStopWords($author).'%']);
        });
        $q->when(request('edition'), function ($q, $edition) {
            return $q->whereRaw('`edition` LIKE ?', ['%'.SearchHelper::stripStopWords($edition).'%']);
        });

        if (request('paginate', true) === true) {
            return $q->paginate(request('per_page', 30));
        }

        return $q->get();
    }

    /**
     * Store a new textbook in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->authorize('create', Textbook::class);

        try {
            $data = $this->getData($request);
            if (!$data['image-url']) {
                $data['image-url'] = Textbook::uploadImage($data['isbn'], $request->file('image'));
            }

            $book = Textbook::create($data);
            event(new BookAdded($book));

            return $book;
        } catch (Exception $exception) {
            return ExceptionHelper::handleError($exception, $request);
        }
    }

    /**
     * Display the specified textbook.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show(Request $request, Textbook $book)
    {
        return $book->load('tags');
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
        $q = TextbookView::where('isbn-viewed', $id)->selectRaw('MONTH(`date-viewed`) as month, count(*) as score')->groupBy(DB::raw('month'))->distinct();

        if ($request['university']) {
            $q->where('uni-viewed', $request['university']);
        }

        if ($request['user']) {
            $q->where('user-id', $request['user']);
        }

        if ($request['not_user']) {
            $q->where('user-id', '!=', $request['not_user']);
        }

        if ($request['past_year']) {
            $q->whereRaw('`date-viewed` >= DATE_SUB(NOW(),INTERVAL 1 YEAR)');
        }
        $textbook = $q->get();

        return $textbook;
    }

    /**
     * Update the specified textbook in the storage.
     *
     * @param int                     $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update(Textbook $book, Request $request)
    {
        $this->authorize('update', $book);

        try {
            $request['isbn'] = $book->isbn;

            $data = $this->getData($request);

            if (!$data['image-url']) {
                $data['image-url'] = Textbook::uploadImage($data['isbn'], $request->file('image'));
            }

            $book->update($data);

            return $book;
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
            'isbn'       => 'required|numeric|digits:13|unique:textbooks,isbn,'.$request->isbn.',isbn',
            'book-title' => 'required|string|min:5|max:259',
            'author'     => 'required|string|min:5|max:259',
            'book-des'   => 'sometimes|string',
            'edition'    => 'nullable|string|min:1|max:64',
            'image-url'  => 'required_without:image|url',
            'image'      => 'required_without:image-url|image|max:20480',

        ];

        $data = $request->validate($rules);

        return $data;
    }
}

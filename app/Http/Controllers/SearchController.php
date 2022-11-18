<?php

namespace App\Http\Controllers;

use App\Helpers\SearchHelper;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Textbook;
use App\Models\University;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function books(Request $request, $q)
    {
        //Get all records from Textbooks table
        if (!empty($q)) {
            //            $q = urldecode($q);
            $q = SearchHelper::stripStopWords($q);
            $q = preg_replace('/[^A-Za-z0-9, ]/', '', $q);
            if (preg_match('/0-9 /', $q)) {
                $q = preg_replace('/[^0-9]/', '', $q);
            }
        } else {
            $q = '978';
        }
        // return $q;
        $uni = $request->input('uni', null);

        return Textbook::where('book-title', 'like', '%' . $q . '%')->orWhere('author', 'like', '%' . $q . '%')->orWhere('isbn', 'like', '%' . $q . '%');

        return Textbook::whereRaw('`book-title` LIKE ? OR `author` LIKE ? OR MATCH (textbooks.`isbn`, `book-title`, `edition`, `author`) AGAINST (?) OR soundex(textbooks.`book-title`) LIKE soundex(?) OR isbn LIKE ?', ['%' . $q . '%', '%' . $q . '%', '*' . $q . '*', '*' . $q . '*', '%' . $q . '%'])->orderByRaw('MATCH (textbooks.`isbn`, `book-title`, `edition`, `author`) AGAINST (?) DESC', ['*' . $q . '*'])->withCount([
            'posts' => function ($query) use ($uni) {
                $query->available()->active()->when($uni, function ($query) use ($uni) {
                    return $query->where('uni-id', $uni);
                });
            },
        ])->paginate(30);
    }

    public function universities($q)
    {
        //Get all records from Textbooks table
        $q = SearchHelper::stripStopWords($q);

        return University::whereRaw("MATCH (`uni-name`, `en-name`, `abr`) AGAINST (? IN NATURAL LANGUAGE MODE) OR `uni-name` LIKE '%?%' OR `en-name` LIKE '%?%' OR `abr` LIKE '%?%'", ['?' => $q])->orderByRaw('MATCH (`uni-name`, `en-name`, `abr`) AGAINST (? IN NATURAL LANGUAGE MODE) DESC', ['?' => $q])->with('country')->paginate(30);
    }

    public function posts($q)
    {
        //Get a single record by ID
        $q = SearchHelper::stripStopWords($q);

        return Post::available()->active()->leftJoin('textbooks', 'textbooks.isbn', '=', 'posts.isbn')->whereRaw("MATCH (textbooks.`isbn`, `book-title`, `edition`, `author`, `book-des`) AGAINST ('*$q*' IN BOOLEAN MODE)")->paginate(30);
    }

    public function users($q)
    {
        //Get all records from users table
        $q = SearchHelper::stripStopWords($q);

        return User::whereRaw('`name` LIKE ? OR soundex(`name`) = soundex(?)', ['?' => $q])->with('university')->paginate(30);
    }

    public function tags($q)
    {
        //Get all records from tags table
        $q = SearchHelper::stripStopWords($q);

        return Tag::whereRaw('`t-data` LIKE ? OR soundex(`t-data`) = soundex(?)', ['?' => $q])->with(['universities', 'textbooks'])->paginate(30);
    }
}

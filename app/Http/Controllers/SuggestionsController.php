<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Textbook;
use App\Models\User;
use App\Models\WebometricUniversity;
use Auth;
use Illuminate\Http\Request;

class SuggestionsController extends Controller {

	/**
	 * Enforce middleware.
	 */
	public function __construct() {
		$this->middleware('auth:api', ['only' => ['text']]);
	}

	public function textbooks(Request $request) {
		$uni = $request->input('university', null);

		//Get all records from Textbooks table
		return Textbook::select('textbooks.isbn', 'textbooks.book-title', 'textbooks.image-url', 'textbooks.author', 'textbooks.edition')
			->whereHas('posts', function ($q) use ($uni) {
				if ($uni) {
					$q->where('uni-id', '=', $uni);
				}
				$q->active()->available();

			})
			->whereHas('purchases', function ($q) use ($uni) {
				$q->whereRaw("timestamp  >= DATE_SUB(NOW(),INTERVAL 13 MONTH) AND timestamp <= DATE_SUB(NOW(),INTERVAL 7 MONTH)");
			})
			->groupBy('textbooks.isbn')
			->orderByRaw("(SELECT COUNT(posts.`post-id`) FROM posts WHERE posts.`isbn` = textbooks.`isbn`) DESC")
			->paginate(8);
	}

	public function universityBooks(Request $request, WebometricUniversity $university) {
		return Textbook::join('tags_textbooks', 'tags_textbooks.isbn', '=', 'textbooks.isbn')
			->join('university_tags', 'tags_textbooks.tag-id', '=', 'university_tags.tag_id')
			->where("university_tags.uni_id", $university->{'uni-id'})
			->withCount([
				'posts' => function ($q) use ($university) {
					$q->active()->available()->where('uni-id', $university->{'uni-id'});
				},
			])
			->orderBy('posts_count', 'DESC')
			->groupBy('textbooks.isbn')
			->paginate(8);
	}

	public function otherEditions(Request $request, $isbn) {
		$book = Textbook::find($isbn);
		$uni = $request->input('university', null);
		$title = $request->input('title', $book['book-title']);
		$author = $request->input('author', null);
		//Get all records from Textbooks table
		return Textbook::where('isbn', '!=', $isbn)
			->where('book-title', '=', $title)
			->whereHas('posts', function ($q) use ($uni) {
				if ($uni) {
					$q->where('uni-id', '=', $uni);
				}
				$q->active()->available();

			})
			->withCount(['posts' => function ($q) use ($uni) {
				if ($uni) {
					$q->where('uni-id', '=', $uni);
				}
				$q->active()->available();

			}])
			->paginate(7);
	}

	public function recent(Request $request) {
		$uni = $request->input('university', null);

		$perPage = $request['per_page'] ?? '8';

		return Textbook::whereHas('posts', function ($q) use ($uni) {
			if ($uni) {
				$q->where('uni-id', '=', $uni);
			}
			$q->active()->available();
		})
			->groupBy('isbn')
			->orderByRaw("(SELECT MAX(textbook_user_view.`date-viewed`) FROM textbook_user_view WHERE textbook_user_view.`isbn-viewed` = textbooks.isbn) DESC")
			->paginate($perPage);
	}

	public function text() {
		//Get all records from Textbooks table
		return Post::select('post-description')
			->where([
				['user-id', '=', Auth::user()->{'user-id'}],
				['status', '<', '10'],
			])
			->whereRaw("length(`post-description`) < 37 and length(`post-description`) >= 11")
			->groupBy('post-description')
			->orderByRaw('count(`post-description`) DESC')
			->take(5)
			->get();
	}

}
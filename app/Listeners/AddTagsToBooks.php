<?php

namespace App\Listeners;

use App\Events\TagAdded;
use App\Models\Textbook;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddTagsToBooks implements ShouldQueue {
	/**
	 * Create the event listener.
	 *
	 * @return void
	 */
	public function __construct() {
		//
	}

	/**
	 * Handle the event.
	 *
	 * @param  TagAdded  $event
	 * @return void
	 */
	public function handle(BookAdded $event) {
		$books = Textbook::get();
		foreach ($books as $book) {
			if (stripos($event->tag->{'t-data'}, $book['book-title']) !== false) {
				$event->tag->textbookTags()->create([
					'isbn' => $book->isbn,
					'tag-id' => $event->tag->{'tag-id'},
				]);
			}
		}
	}
}

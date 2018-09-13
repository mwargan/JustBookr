<?php

namespace App\Helpers;

class SearchHelper {
	/**
	 * Handle exception
	 *
	 * @param Illuminate\Http\Request\Request $request
	 * @return array
	 */
	public static function stripStopWords($string) {

		$wordlist = array("or", "and", "the", "of", "for", "in", "a", "to", "an", "that", "our", "in", "&", "-", ":", "?", "!", "ISBN-13", "ISBN13", "ISBN", "edition", "author");

		foreach ($wordlist as &$word) {
			$word = '/\b' . preg_quote($word, '/') . '\b/i';
		}

		return trim(preg_replace($wordlist, '', $string));
	}
}
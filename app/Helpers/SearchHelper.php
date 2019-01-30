<?php

namespace App\Helpers;

class SearchHelper
{
    /**
     * Handle exception.
     *
     * @param Illuminate\Http\Request\Request $request
     *
     * @return array
     */
    public static function stripStopWords($string)
    {
        $wordlist = ['or', 'and', 'the', 'of', 'for', 'in', 'an', 'a', 'to', 'that', 'our', 'in', 'on', 'is', '&', ':', '?', '!', 'ISBN-13', 'ISBN13', 'ISBN 13', 'ISBN', 'editions', 'edition', 'authors', 'author'];

        foreach ($wordlist as &$word) {
            $word = '/\b'.preg_quote($word, '/').'\b/i';
        }

        return trim(preg_replace($wordlist, '', $string));
    }
}

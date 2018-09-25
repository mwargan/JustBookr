<?php

namespace App\Http\Controllers;

use App\Models\Textbook;
use App\Models\University;
use App\Models\User;
use Illuminate\Http\Request;

class MessengerController extends Controller {

	public function books(Request $request, $q) {
		//Get all records from Textbooks table
		if (!empty($q)) {
			$q = urldecode($q);
			$q = $this->cleanQuery($q);
			$q = preg_replace('/[^A-Za-z0-9, ]/', '', $q);
			if (preg_match("/0-9 /", $q)) {
				$q = preg_replace('/[^0-9]/', '', $q);
			}
		} else {
			$q = "978";
		}
		if ($request->input('uni')) {
			$uni = $request->input('uni');
		} elseif ($request->user('api') && $request->user('api')->{'uni-id'}) {
			$uni = $request->user('api')->{'uni-id'};
		} else {
			$uni = null;
		}
		$books = Textbook::whereRaw("`book-title` LIKE ? OR MATCH (textbooks.`isbn`, `book-title`, `edition`, `author`) AGAINST (?) OR soundex(textbooks.`book-title`) LIKE soundex(?)", ['%' . $q . '%', '*' . $q . '*', '*' . $q . '*'])->orderByRaw("MATCH (textbooks.`isbn`, `book-title`, `edition`, `author`) AGAINST (?) DESC", ['*' . $q . '*'])->withCount([
			'posts' => function ($query) use ($uni) {
				$query->available()->active()->when($uni, function ($query) use ($uni) {
					return $query->where('uni-id', $uni);
				});
			},
		])->paginate(9);
		$det = array();

		foreach ($books as $row) {
			$row_array['title'] = $row['book-title'];

			if ($row['edition']) {
				$row_array['title'] .= " | " . $row['edition'] . " Edition";
			}

			$row_array['image_url'] = $row['image-url'];
			$row_array['subtitle'] = $row['author'];
			$urllink = "https://justbookr.com/textbook/" . $row['isbn'];
			$sell_link = "https://justbookr.com/sell/" . $row['isbn'];
			$row_array['item_url'] = $urllink;
			if ($row['posts_count'] == 0) {
				$row_array['buttons'] = array(array('type' => 'web_url', 'url' => $urllink, 'title' => 'See the book'), array('type' => 'web_url', 'url' => $sell_link, 'title' => 'Sell your copy'), array('type' => 'element_share'));
			} else {
				$row_array['buttons'] = array(array('type' => 'web_url', 'url' => $urllink . '#selling', 'title' => 'Buy the book (' . $row['posts_count'] . ')'), array('type' => 'web_url', 'url' => $sell_link, 'title' => 'Sell your copy'), array('type' => 'element_share'));
			}
			array_push($det, $row_array);
		}
		$row_array['title'] = "Find more textbooks on JustBookr";
		$row_array['subtitle'] = "Search for textbooks sold by fellow classmates right at your university campus! It's free!";
		$row_array['image_url'] = "";
		$urllink = "https://justbookr.com/";
		$row_array['item_url'] = $urllink;
		$row_array['buttons'] = array(array('type' => 'web_url', 'url' => 'https://justbookr.com', 'title' => 'See all books'), array('type' => 'web_url', 'url' => 'https://justbookr.com', 'title' => 'Go to JustBookr'), array('type' => 'element_share'));
		array_push($det, $row_array);
		$final = array(
			'messages' => array(
				array("attachment" => array(
					"type" => "template", "payload" => array(
						"template_type" => "generic", "elements" => $det,
					),
				),
				),
				array("text" => "Hope this helps! You can also always find more textbooks on JustBookr.com!"),
			),
		);
		return response()->json($final);
	}
	public function universities($q) {
		//Get all records from Textbooks table
		$universities = University::whereRaw("MATCH (`uni-name`, `en-name`, `abr`) AGAINST (? IN NATURAL LANGUAGE MODE) OR `uni-name` LIKE '%?%' OR `en-name` LIKE '%?%' OR `abr` LIKE '%?%'", [$q, $q, $q, $q])->orderByRaw("MATCH (`uni-name`, `en-name`, `abr`) AGAINST (? IN NATURAL LANGUAGE MODE) DESC", [$q])->with('country')->paginate(9);
		$det = array();

		foreach ($universities as $row) {
			$row_array['title'] = $row['uni-name'];
			$row_array['image_url'] = $row['uni-logo'];
			$row_array['subtitle'] = $row->country->name;
			$urllink = "https://justbookr.com/university/" . $row['uni-id'];
			$row_array['item_url'] = $urllink;
			if ($row['posts_count'] == 0) {
				$row_array['buttons'] = array(array('type' => 'web_url', 'url' => $urllink, 'title' => 'See the university'), array('type' => 'element_share'));
			} else {
				$row_array['buttons'] = array(array('type' => 'web_url', 'url' => $urllink . '#selling', 'title' => 'See university books (' . $row['posts_count'] . ')'), array('type' => 'element_share'));
			}
			array_push($det, $row_array);
		}
		$row_array['title'] = "Find more universities on JustBookr";
		$row_array['subtitle'] = "Search for universities and textbooks sold by fellow classmates right on JustBookr! It's free!";
		$row_array['image_url'] = "";
		$urllink = "https://justbookr.com/";
		$row_array['item_url'] = $urllink;
		$row_array['buttons'] = array(array('type' => 'web_url', 'url' => 'https://justbookr.com', 'title' => 'See all universities'), array('type' => 'web_url', 'url' => 'https://justbookr.com', 'title' => 'Go to JustBookr'), array('type' => 'element_share'));
		array_push($det, $row_array);
		$final = array(
			'messages' => array(
				array("attachment" => array(
					"type" => "template", "payload" => array(
						"template_type" => "generic", "elements" => $det,
					),
				),
				),
				array("text" => "Hope this helps! You can also always find more textbooks on JustBookr.com!"),
			),
		);
		return response()->json($final);
	}
	protected function cleanQuery($q) {
		$wordlist = array("or", "and", "the", "of", "for", "in", "a", "to", "an", "that", "our", "in", "&", "-", ":", "ISBN-13", "ISBN13", "ISBN", "edition");

		foreach ($wordlist as &$word) {
			$word = '/\b' . preg_quote($word, '/') . '\b/i';
		}

		return trim(preg_replace($wordlist, '', $q));
	}
}
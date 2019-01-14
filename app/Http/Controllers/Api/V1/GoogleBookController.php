<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Textbook;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class GoogleBookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search($input)
    {
        $client = new Client();
        $res = $client->get('https://www.googleapis.com/books/v1/volumes',
            [
                'query' => [
                    'key' => config('services.googleBooks.key'),
                    'q' => $input,
                ],
            ]
        );
        $res->getStatusCode(); // 200
        $response = json_decode($res->getBody());
        $results = [];
        if (!$response || !isset($response->items)) {
            return response()->json($response);
        }
        foreach ($response->items as $item) {
            $formattedResponse = $this->transformToJustBookrFormat($item, request('save', false));
            if ($formattedResponse) {
                array_push($results, $formattedResponse);
            }
        }
        if (request('format', 'JustBookr') == 'google') {
            return response()->json($response);
        }

        return response()->json($results);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($input)
    {
        $client = new Client();
        $res = $client->get('https://www.googleapis.com/books/v1/volumes',
            [
                'query' => [
                    'key' => config('services.googleBooks.key'),
                    'q' => 'isbn: ' . $input,
                ],
            ]
        );
        $res->getStatusCode(); // 200
        $response = json_decode($res->getBody());
        if (!$response || !isset($response->items)) {
            return response()->json('No book found', 404);
        }
        $result = $this->transformToJustBookrFormat($response->items[0], request('save', true));
        if (!isset($result->isbn)) {
            return response()->json(['errors' => 'There was an error'], 422);
        }
        if (request('format', 'JustBookr') == 'google') {
            return response()->json($response);
        }
        return response()->json($result);
    }

    public function transformToJustBookrFormat($response, $save)
    {
        $result = null;
        $isbn = null;
        $description = null;
        $edition = null;
        $image = null;
        $data = $response->volumeInfo;

        if (!isset($data->industryIdentifiers)) {
            return;
        }

        foreach ($data->industryIdentifiers as $identifier) {
            if ($identifier->type === 'ISBN_13') {
                $isbn = $identifier->identifier;
                break;
            }
            continue;
        }

        $title = $data->title;
        if (isset($data->subtitle)) {
            $title .= ' - ' . $data->subtitle;
        }
        if (isset($data->authors)) {
            $authors = implode(', ', $data->authors);
        } elseif (isset($data->publisher)) {
            $authors = $data->publisher;
        } else {
            $authors = 'Authors unavailable';
        }
        if (isset($data->description)) {
            $description = $data->description;
        }

        if (isset($data->edition)) {
            $edition = $data->edition;
        } elseif (isset($data->publishedDate)) {
            $edition = substr($data->publishedDate, 0, 4);
        }
        if (isset($data->imageLinks)) {
            $image = preg_replace('/^http:/i', 'https:', $data->imageLinks->thumbnail);
        }

        $link = $data->canonicalVolumeLink;

        if (!$isbn || !$data || !$image) {
            return;
        }

        $result = [
            'isbn' => $isbn,
            'book-title' => $title,
            'author' => $authors,
            'book-des' => $description,
            'edition' => $edition,
            'image-url' => $image,
            'isGoogle' => true,
            'googleLink' => $link,
        ];

        if ($save == true) {
            Textbook::firstOrCreate(['isbn' => $result['isbn']], $result);
        }
        return (object) $result;
    }
}

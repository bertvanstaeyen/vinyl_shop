<?php

namespace App\Http\Controllers;

use App\Genre;
use App\Record;
use Facades\App\Helpers\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class ShopController extends Controller
{
    public function index(Request $request) {
        $genre_id = $request->input('genre_id') ?? '%';
        $artist_title = '%' . $request->input('artist') . '%';

        $records = Record::orderBy('artist')->with('genre')
            ->where([
                ['artist', 'like', $artist_title],
                ['genre_id', 'like', $genre_id]
            ])
            ->orWhere([
                ['title', 'like', $artist_title],
                ['genre_id', 'like', $genre_id]
            ])
            ->paginate(12)
            ->appends(['artist'=> $request->input('artist'), 'genre_id' => $request->input('genre_id')]);

        foreach ($records as $record) {
            if(!$record->cover) {
                $record->cover = "https://coverartarchive.org/release/{$record->title_mbid}/front-250.jpg'";
            }
        }
        // short version of orderBy('name', 'asc')
        $genres = Genre::orderBy('name')->has('records')->withCount('records')->get()->transform(function ($item, $key) {
            // Set first letter of name to uppercase and add the counter
            $item->name = ucfirst($item->name) . ' (' . $item->records_count . ')';
            return $item;
        })  ->makeHidden(['created_at', 'updated_at', 'records_count']);
        $result = compact('records', 'genres');     // $result = ['genres' => $genres, 'records' => $records]
        Json::dump($result);
        return view('shop.index', $result);
    }

    public function alt(Request $request) {
        $genres = Genre::has('records')->with(['records' => function($q) {
            $q->orderBy('artist', 'asc');
        }])->get()->transform(function ($item, $key) {
            $item->name = ucfirst($item->name);
            return $item;
        })->sortBy('name');

        $result = compact( 'genres');     // $result = ['genres' => $genres, 'records' => $records]
        Json::dump($result);
        return view('shop.altindex', $result);
    }

    public function show($id) {
        $record = Record::with('genre')->findOrFail($id);
        $record->cover = $record->cover ?? "https://coverartarchive.org/release/$record->title_mbid/front-500.jpg";
        $record->title = $record->artist . ' - ' . $record->title;
        $record->recordUrl = 'https://musicbrainz.org/ws/2/release/' . $record->title_mbid . '?inc=recordings+url-rels&fmt=json';
        $record->btnClass = $record->stock > 0 ? 'btn-outline-success' : 'btn-outline-danger disabled';
        $record->genreName = $record->genre->name;
        $record->price = number_format($record->price,2);
        $record->makeHidden(['genre', 'artist', 'genre_id', 'created_at', 'updated_at', 'title_mbid', 'genre']);

        // Get record info and convert to JSON
        $response = Http::get($record->recordUrl)->json();
        $tracks = $response['media'][0]['tracks'];

        $tracks = collect($tracks)
            ->transform(function ($item, $key) {
                // Conert ms to seconds
                $item['length'] = date('i:s', $item['length'] / 1000);
                unset($item['id'], $item['recording'], $item['number']);
                return $item;
            });

        $result = compact('tracks', 'record');

        Json::dump($result);
        return view('shop.show', $result);
    }
}

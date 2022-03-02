<?php

namespace App\Http\Controllers;

use Facades\App\Helpers\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ItunesController extends Controller
{
    public function index() {

        $fetchUrl = "https://rss.applemarketingtools.com/api/v2/be/music/most-played/12/songs.json";

        $response = Http::get($fetchUrl)->json();
        $title = $response['feed']['title'];
        $countryCode = strtoupper($response['feed']['country']);
        $updated = $response['feed']['updated'];
        $songs = $response['feed']['results'];
        $updated = date("F d Y", strtotime($updated));

        // Reform date
        $result = compact('title', 'countryCode', 'updated','songs');
        //dd($result);
        Json::dump($result);
        return view('itunes', $result);
    }
}

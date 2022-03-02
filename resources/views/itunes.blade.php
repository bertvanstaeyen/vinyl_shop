@extends('layouts.template')
@section('title', 'The Vinyl Shop')

@section('main')
    <h1 class="mb-0">iTunes {{$title}} - {{$countryCode}}</h1>
    <p class="text-muted">Last updated: {{$updated}}</p>

    <div class="row">
        @foreach ($songs as $song)
            <div class="col-sm-6 col-md-4 col-lg-3 mb-3">
                <div class="card">
                    <img class="card-img-top" src="/assets/vinyl.png" data-src="{{$song['artworkUrl100']}}" alt="artist artwork">
                    <div class="card-body">
                        <h5 class="card-title mb-1">{{$song['artistName']}}</h5>
                        <p class="card-text text-muted">{{$song['name']}}</p>
                        <hr/>
                        <p class="mb-1 text-muted">Genre: {{$song['genres'][0]['name']}}</p>
                        <p class="mb-0 text-muted">Artist URL: <a href="{{$song['artistUrl']}}">{{$song['artistName']}}</a></p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('script_after')
    <script>
        // Replace vinyl.png with real cover
        $('.card img').each(function () {
            let url = $(this).data('src');
            url = url.substring(0, url.length - 13);
            url = url + "500x500bb.jpg";
            $(this).attr('src', url);
        });
    </script>
@endsection

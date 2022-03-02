@extends('layouts.template')

@section('title', 'Shop')

@section('main')
    <h1>Shop</h1>
    <form method="get" action="/shop" id="searchForm">
        <div class="row">
            <div class="col-sm-7 mb-2">
                <input type="text" class="form-control col-sm-12" name="artist" id="artist"
                       value="{{ request()->artist }}"
                       value="" placeholder="Filter Artist Or Record">
            </div>
            <div class="col-sm-5 mb-2">
                <select class="form-control" name="genre_id" id="genre_id">
                    <option value="%">All genres</option>
                    @foreach($genres as $genre)
                        <option value="{{ $genre->id }}"
                            {{ (request()->genre_id ==  $genre->id ? 'selected' : '') }}>{{ $genre->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>
    <hr>
    @if ($records->count() == 0)
        <div class="alert alert-danger alert-dismissible fade show">
            @if (request()->genre_id > 0)
                <p class="m-0">Can't find any artist or album with <b>'{{ request()->artist }}'</b> and genre <b>{{$genres->first(function($item){
                    return $item->id == request()->genre_id;
                })->name}}</b></p>
            @else
                <p class="m-0">Can't find any artist or album with <b>'{{ request()->artist }}'</b></p>
            @endif

            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    {{ $records->links() }}
    <div class="row cardShopMaster">
        @foreach($records as $record)
        <div class="col-sm-6 col-md-4 col-lg-3 mb-3 d-flex">
            <div class="card" data-id="{{ $record->id }}">
                <img class="card-img-top" src="/assets/vinyl.png" data-src="{{ $record->cover }}" alt="{{ $record->artist }} - {{ $record->title }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $record->artist }}</h5>
                    <p class="card-text">{{ $record->title }}</p>
                    <a href="shop/{{ $record->id }}" class="btn btn-outline-info btn-sm btn-block">Show details</a>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <p>{{ $record->genre->name }}</p>
                    <p>
                        € {{ number_format($record->price,2) }}
                        <span class="ml-3 badge badge-success">{{ $record->stock }}</span>
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    {{ $records->links() }}
@endsection

@section('script_after')
    <script>
        $(function () {
            // Get record id and redirect to the detail page
            $('.card').click(function () {
                const record_id = $(this).data('id');
                $(location).attr('href', `/shop/${record_id}`); //OR $(location).attr('href', '/shop/' + record_id);
            });
            // Replace vinyl.png with real cover
            $('.card img').each(function () {
                $(this).attr('src', $(this).data('src'));
            });
            // Add shadow to card on hover
            $('.card').hover(function () {
                $(this).addClass('shadow');
            }, function () {
                $(this).removeClass('shadow');
            });
            // submit form when leaving text field 'artist'
            $('#artist').blur(function () {
                $('#searchForm').submit();
            });
            // submit form when changing dropdown list 'genre_id'
            $('#genre_id').change(function () {
                $('#searchForm').submit();
            });
        })
    </script>
@endsection

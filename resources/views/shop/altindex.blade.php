@extends('layouts.template')

@section('title', 'Shop')

@section('main')
    <h1>Shop - alternative listing</h1>
    @if ($genres->count() == 0)
        <div class="alert alert-danger alert-dismissible fade show">
            Can't find any artist or album.
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    @foreach($genres as $genre)
        <h2>{{$genre->name}}</h2>
        <ul>
        @foreach($genre->records as $record)
            <li><a href="shop/{{ $record->id }}">{{$record->artist}} - {{$record->title}}</a> | Price: € {{$record->price}} | Stock: {{$record->stock}}</li>
        @endforeach
        </ul>
    @endforeach
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

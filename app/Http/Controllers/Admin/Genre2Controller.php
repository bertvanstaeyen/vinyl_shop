<?php

namespace App\Http\Controllers\Admin;

use App\Genre;
use App\Helpers\Json;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Genre2Controller extends Controller
{

    public function index()
    {
        return view('admin.genres2.index');
    }


    public function create()
    {
        return redirect('admin/genres2');
    }

    public function store(Request $request)
    {
        // Validate $request
        $this->validate($request,[
            'name' => 'required|min:3|unique:genres,name'
        ]);

        // Create new genre
        $genre = new Genre();
        $genre->name = $request->name;
        $genre->save();

        // Return a success message to master page
        return response()->json([
            'type' => 'success',
            'text' => "The genre <b>$genre->name</b> has been added"
        ]);
    }


    public function show()
    {
        return redirect('admin/genres2');
    }

    public function edit(Genre $genre)
    {
        return redirect('admin/genres2');
    }

    public function update(Request $request, Genre $genre)
    {
        // Validate $request
        $this->validate($request,[
            'name' => 'required|min:3|unique:genres,name,' . $genre->id
        ]);

        // Update genre
        $genre->name = $request->name;
        $genre->save();

        // Return a success message to master page
        return response()->json([
            'type' => 'success',
            'text' => "The genre <b>$genre->name</b> has been updated"
        ]);
    }

    public function destroy(Genre $genre)
    {
        $genre->delete();
        return response()->json([
           'type' => 'success',
           'text' => "The genre <b>$genre->name</b> has been deleted"
        ]);
    }

    public function qryGenres()
    {
        $genres = Genre::orderBy('name')
            ->withCount('records')
            ->get();
        return $genres;
    }
}

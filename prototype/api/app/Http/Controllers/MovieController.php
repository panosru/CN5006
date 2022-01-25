<?php

namespace App\Http\Controllers;

use App\Jobs\FindMovieJob;
use App\Jobs\RetrieveMovieJob;
use App\Models\MovieModel;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $movies = MovieModel::orderBy($request->get('_sort', 'year'), $request->get('_order', 'ASC'))
            ->skip($request->get('_start', 0))
            ->take($request->get('_end', 10))
            ->get();

        return \response()->json($movies)->header('X-Total-Count', MovieModel::count());
    }

    public function show($id)
    {
        return \response()->json(MovieModel::with('shows')->findOrFail($id));
    }

    public function store(Request $request)
    {
        $movie = \dispatch_now(new RetrieveMovieJob($request->get('id')));

        return \response()->json($movie);
    }

    public function find(Request $request)
    {
        $movies = \dispatch_now(new FindMovieJob($request->get('q', '')));

        return \response()->json($movies)->header('X-Total-Count', \count($movies));
    }

    public function update(Request $request, $id)
    {
        $movie = MovieModel::find($id);

        if ($request->exists('title'))
            $movie->title = $request->get('title');

        if ($request->exists('year'))
            $movie->year = $request->get('year');

        if ($request->exists('rating'))
            $movie->rating = $request->get('rating');

        if ($request->exists('genres'))
            $movie->genres = $request->get('genres');

        if ($request->exists('directors'))
            $movie->directors = $request->get('directors');

        if ($request->exists('stars'))
            $movie->stars = $request->get('stars');

        if ($request->exists('trailer'))
            $movie->trailer = $request->get('trailer');

        if ($request->exists('plot'))
            $movie->plot = $request->get('plot');

        if ($request->exists('duration'))
            $movie->duration = $request->get('duration');

        if ($movie->isDirty())
            $movie->save();

        return \response()->json($movie);
    }

    public function delete($id)
    {
        $movie = MovieModel::find($id);
        $movie->delete();

        return \response()->json(null, 204);
    }
}

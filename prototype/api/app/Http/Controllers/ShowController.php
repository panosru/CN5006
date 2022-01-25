<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\ShowModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class ShowController extends Controller
{
    public function index(Request $request, bool $future = false)
    {
        $shows = ShowModel::with('movie')
            ->with('hall')
            ->when($future, function ($query) {
                return $query->where('datetime', '>', Carbon::now('Europe/Athens'));
            })
            ->orderBy($request->get('_sort', 'datetime'), $request->get('_order', 'ASC'))
            ->skip($request->get('_start', 0))
            ->take($request->get('_end', 10))
            ->get();

        return \response()->json($shows)->header('X-Total-Count', ShowModel::count());
    }

    public function future(Request $request)
    {
        return $this->index($request, true);
    }

    public function show($id)
    {
        return \response()->json(
            ShowModel::with('movie')
                ->with('hall')
                ->find($id));
    }

    public function showTickets($id)
    {
        return \response()->json(
            ShowModel::with('tickets')
                ->find($id));
    }

    public function store(Request $request)
    {
        $show = ShowModel::create([
            'id' => Uuid::uuid4()->toString(),
            'movie_id' => $request->get('movie_id'),
            'hall_number' => $request->get('hall_number'),
            'datetime' => $request->get('datetime')
        ]);

        return \response()->json($show);
    }

    public function update(Request $request, $id)
    {
        $show = ShowModel::find($id);

        if ($request->exists('datetime'))
            $show->datetime = $request->get('datetime');

        if ($request->exists('movie_id'))
            $show->movie_id = $request->get('movie_id');

        if ($request->exists('hall_number'))
            $show->hall_number = $request->get('hall_number');

        if ($show->isDirty())
            $show->save();

        return \response()->json($show);
    }

    public function delete($id)
    {
        $show = ShowModel::find($id);
        $show->delete();

        return \response()->json(null, 204);
    }
}

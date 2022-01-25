<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\HallModel;
use Illuminate\Http\Request;

class HallController extends Controller
{
    public function index(Request $request)
    {
        $halls = HallModel::orderBy($request->get('_sort', 'number'), $request->get('_order', 'ASC'))
            ->skip($request->get('_start', 0))
            ->take($request->get('_end', 10))
            ->get();

        return \response()->json($halls)->header('X-Total-Count', HallModel::count());
    }

    public function show(int $number)
    {
        $hall = HallModel::find($number);

        return \response()->json($hall);
    }

    public function store(Request $request)
    {
        $hall = HallModel::create($request->all());

        return \response()->json($hall);
    }

    public function update(Request $request, int $number)
    {
        $hall = HallModel::find($number);

        if ($request->exists('rows'))
            $hall->rows = $request->get('rows');

        if ($request->exists('seats_per_row'))
            $hall->seats_per_row = $request->get('seats_per_row');

        if ($hall->isDirty())
            $hall->save();

        return \response()->json($hall);
    }

    public function delete(int $number)
    {
        $hall = HallModel::find($number);
        $hall->delete();

        return \response()->json(null, 204);
    }
}

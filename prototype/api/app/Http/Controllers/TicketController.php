<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\ShowModel;
use App\Models\TicketModel;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $tickets = TicketModel::with([
            'show.hall' => function ($query) {
                $query->select('number', 'rows', 'seats_per_row');
            },
            'show.movie',
            'user'
        ])
            ->orderBy($request->get('_sort', 'datetime'), $request->get('_order', 'ASC'))
            ->skip($request->get('_start', 0))
            ->take($request->get('_end', 10))
            ->get();

        return \response()->json($tickets)->header('X-Total-Count', TicketModel::count());
    }

    public function show($id)
    {
        $ticket = TicketModel::with([
            'show.hall' => function ($query) {
                $query->select('number', 'rows', 'seats_per_row');
            },
            'show.movie',
            'user'
        ])
        ->find($id);

        return \response()->json($ticket);
    }

    public function book(Request $request)
    {
        return $this->store($request, true);
    }

    public function store(Request $request, bool $current_user = false)
    {
        // Validate request
        $this->validate($request, [
            'show_id' => 'required',
            'seat' => 'required|integer|min:1',
            'row' => 'required|integer|min:1',
        ]);

        // Check how many tickets are available
        $show = ShowModel::find($request->get('show_id'));

        if ($show->hall->capacity <= $show->tickets->count())
            return \response()->json(['message' => 'No more tickets available'], 400);

        // Check if seat exists
        if (    $request->get('row') > $show->hall->rows
            ||  $request->get('seat') > $show->hall->seats_per_row)
            return \response()->json(['message' => 'Seat does not exist'], 400);

        // Check if the seat is available
        $seat = $show->tickets
            ->where('row', $request->get('row'))
            ->where('seat', $request->get('seat'))
            ->first();

        if ($seat)
            return \response()->json(['message' => 'Seat is already taken'], 400);

        $ticket = TicketModel::create(\array_merge(
            $request->all(['row','seat','show_id']),
            [
                'user_id' => $current_user ? $request->get('current_user_id') : $request->get('user_id'),
                'id' => Uuid::uuid4()->toString()
            ]
        ));

        return \response()->json($ticket);
    }

    public function update(Request $request, string $id)
    {
        // Validate request
        $this->validate($request, [
            'seat' => 'required|integer|min:1',
            'row' => 'required|integer|min:1',
        ]);

        $ticket = TicketModel::find($id);

        // Check if row is changed
        if ($ticket->row !== $request->get('row'))
            $ticket->row = $request->get('row');

        // Check if seat is changed
        if ($ticket->seat !== $request->get('seat'))
            $ticket->seat = $request->get('seat');

        if ($ticket->isDirty())
        {
            // Check if the seat is available
            $seat = $ticket->show->tickets
                ->where('row', $request->get('row'))
                ->where('seat', $request->get('seat'))
                ->first();

            if ($seat)
                return \response()->json(['message' => 'Seat is already taken'], 400);

            $ticket->save();
        }


        return \response()->json($ticket);
    }

    public function delete($id)
    {
        $ticket = TicketModel::find($id);
        $ticket->delete();

        return \response()->json(null, 204);
    }
}

<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\OptionsModel;
use Illuminate\Http\Request;

class OptionsController extends Controller
{
    public function index()
    {
        return \response()->json(OptionsModel::all())->header('X-Total-Count', OptionsModel::count());
    }

    public function show(string $key)
    {
        return \response()->json(OptionsModel::find($key));
    }

    public function store(Request $request)
    {
        // Validate request
        $this->validate($request, [
            'key' => 'required|string|max:255',
            'value' => 'required|string|max:255',
        ]);

        $option = OptionsModel::create([
            'key' => $request->key,
            'value' => $request->value,
        ]);

        return \response()->json($option);
    }

    public function update(Request $request, string $key)
    {
        $option = OptionsModel::find($key);

        if (0 !== \strcmp($option->value, $request->get('value')))
            $option->value = $request->get('value');

        if ($option->isDirty())
            $option->save();

        return \response()->json($option);
    }

    public function delete(string $key)
    {
        $option = OptionsModel::find($key);
        $option->delete();

        return \response()->json(null, 204);
    }
}

<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\RoleModel;
use Illuminate\Http\Request;

class AclController extends Controller
{
    public function roles(Request $request)
    {
        //roles?_sort=name&_order=ASC&_start=0&_end=24
        $roles = RoleModel::orderBy($request->get('_sort', 'name'), $request->get('_order', 'ASC'))
            ->skip($request->get('_start', 0))
            ->take($request->get('_end', 10))
            ->get();

        $result = [];

        $roles->each(function ($role) use (&$result) {
            $result[] = [
                'id' => $role->id,
                'name' => $role->name,
                'display_name' => $role->display_name,
                'description' => $role->description
            ];
        });

        return \response()->json($result)->header('X-Total-Count', RoleModel::count());
    }
}

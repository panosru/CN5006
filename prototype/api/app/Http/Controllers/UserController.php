<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\AppRole;
use App\Jobs\SendRegistrationEmailJob;
use App\Models\UserModel;
use App\Models\TicketModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Queue;
use Maklad\Permission\Models\Permission;
use Maklad\Permission\Models\Role;
use Ramsey\Uuid\Uuid;

class UserController extends Controller
{
    public function index(Request $request)
    {
        //\Illuminate\Support\Facades\Queue::push(new ExampleJob());

        //dispatch(new ExampleJob());

        //event(new \App\Events\EmailSent());

        //$user = UserModel::find('d6fb179e-0847-423c-802a-52e72da04455');
        //
        //TicketModel::create([
        //    'user_id' => $user->id,
        //    'seat' => 'A07',
        //    'movie' => 'Coriolanus',
        //    'hall' => 3,
        //    'date' => '2018-12-12',
        //    'time' => '18:00'
        //]);



        //$ticket = new TicketModel();
        //$ticket->seat = 'A07';
        //$ticket->movie = 'Coriolanus';
        //$ticket->hall = 3;
        //$ticket->date = '2018-12-12';
        //$ticket->time = '18:00';
        //$ticket->user = 'd6fb179e-0847-423c-802a-52e72da04455';
        //$ticket->save();

        //$ticket = TicketModel::with('user')->find('61e3769829e3243ac6551392')->get();
        //$ticket = TicketModel::with('user')->where('user', 'd6fb179e-0847-423c-802a-52e72da04455')->get();
        //
        //return \response()->json($ticket);

        //$role = Role::create(['name' => 'staff']);
        //$permission = Permission::create(['name' => 'list users']);
        //$role->givePermissionTo($permission);


        //users?_sort=name&_order=ASC&_start=0&_end=24
        $users = UserModel::orderBy($request->get('_sort', 'name'), $request->get('_order', 'ASC'))
            ->skip($request->get('_start', 0))
            ->take($request->get('_end', 10))
            ->with('roles')
            ->get();

        return \response()->json($users)->header('X-Total-Count', UserModel::count());

        //foreach ($user->tickets as $ticket) {
        //    echo $ticket->seat . '<br>';
        //}

        //$ticket = TicketModel::find('61e3769829e3243ac6551392')->first();

        //return \response()->json($ticket);

        //return \response()->json(TicketModel::all());

        //return \response()->json(UserModel::all());
    }

    public function profile()
    {
        return \response()->json(Auth::user());
    }

    public function tickets()
    {
        $user = UserModel::with([
            'tickets',
            'tickets.show',
            'tickets.show.movie',
            'tickets.show.hall',
        ])
            ->orderBy('created_at', 'ASC')
            ->find(Auth::id());

        return \response()->json($user);
    }

    public function show($id)
    {
        return \response()->json(UserModel::with('roles')->find($id));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email',
        ]);

        $user = UserModel::find($id);

        // Check if name is changed
        if (0 !== \strcmp($user->name, $request->get('name')))
            $user->name = $request->get('name');

        // Check if surname is changed
        if (0 !== \strcmp($user->surname, $request->get('surname')))
            $user->surname = $request->get('surname');

        // Check if email is changed and if it is, check if it is unique
        if (0 !== \strcmp($user->email, $request->get('email')) &&
            null !== UserModel::where('email', $request->email)->first())
            return \response()->json(['message' => 'User with this email already exists'], 400);

        // Check if is not blank
        if (!empty($request->get('password')))
            $user->password = Hash::make($request->get('password'));

        // Check if model is dirty
        if ($user->isDirty())
            $user->save();

        return \response()->json($user);
    }

    public function delete($id)
    {
        $user = UserModel::find($id);

        $user->delete();

        return \response()->json(['success' => 'User deleted']);
    }

    public function roles(Request $request)
    {
        $roles = UserModel::find($request->get('user_id'))
            ->roles()
            ->get();

        $roles->each(function ($role) {
            $role->id = $role->_id;
        });

        return \response()->json($roles)->header('X-Total-Count', $roles->count());
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = UserModel::where('email', $request->email)->first();

        if ($user)
            return \response()->json(['message' => 'User with this email already exists'], 400);

        $user = UserModel::create([
            'id' => Uuid::uuid4()->toString(),
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return \response()->json($user);
    }

    public function authneticate(Request $request)
    {
        // Check if user exists
        if (Auth::check())
            return \response()->json(['message' => 'User already logged in'], 400);

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = UserModel::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $token = UserModel::createToken();
            $user->update(['api_key' => $token]);
            $roles = [];
            $user->roles()->each(function ($role) use (&$roles) {
                $roles[] = $role->name;
            });
            return \response()->json(['status' => 'success', 'token' => $token, 'roles' => $roles], 200);
        }

        return \response()->json(['status' => 'Unauthenticated'], 401);
    }

    public function logout()
    {
        $user = UserModel::find(Auth::id());
        $user->update(['api_key' => null]);
        return \response()->json(['status' => 'success'], 200);
    }
}

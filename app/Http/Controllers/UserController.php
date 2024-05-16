<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // if ($request->name) {
        //     return response()->json([
        //         'users' => User::where(
        //             'name',
        //             'like',
        //             '%' . $request->name . '%'
        //         )->get()
        //     ]);
        // }

        return response()->json(['users' => User::all()]);
    }

    public function select($id)
    {
        return response()->json(User::findOrFail($id)->first());
    }

    public function edit(Request $request, $id)
    {
        try {
            $payload = $request->only('name', 'email');

            $user = User::findOrFail($id)->first();
            $user->update($payload);

            return response()->json($user);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json($user);
    }

    public function store(CreateUserRequest $request)
    {
        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->passowrd)
        ]);

        $user = User::where('email', $request->email)->first();
        return response()->json(['user' => $user, 'message' => 'Hello!']);
    }

    public function new()
    {
        return response()->json(['message' => 'Hello world!']);
    }
}

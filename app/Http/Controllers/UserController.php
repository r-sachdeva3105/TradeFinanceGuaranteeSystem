<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin'); // Ensure only admins can manage users
    }

    public function adminIndex()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function adminStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'user_type' => 'required|string'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'user_type' => $request->user_type,
        ]);

        return redirect()->route('admin.users')->with('message', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function adminUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id, // Ensure unique email except for the current user
            'user_type' => 'required|in:applicant,reviewer,admin', // Ensure valid role
        ]);

        $user = User::findOrFail($id);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->user_type = $request->input('user_type');

        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        return redirect()->route('admin.users')->with('message', 'User updated successfully.');
    }

    public function adminDestroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users')->with('message', 'User deleted successfully.');
    }
}

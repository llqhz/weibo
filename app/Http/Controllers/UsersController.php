<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function create()
    {
        return view('users/create');
    }

    public function show(User $user)
    {
        return view('users/show', compact('user'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|unique:users|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|string|confirmed|min:6',
        ];
        $this->validate($request, $rules);

        $user = User::create($request->only(['name', 'email', 'password']));

        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
        return redirect()->route('users.show', [$user]);
    }
}

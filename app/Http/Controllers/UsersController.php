<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $user = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ];
        $user = User::create($user);

        // 注册成功则自动登录
        Auth::login($user);
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
        return redirect()->route('users.show', [$user]);
    }

    /**
     * 编辑用户信息
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }


    /**
     * 更新用户个人信息
     */
    public function update(User $user, Request $request)
    {
        $rules = [
            'name' => 'required|string|max:50',
            'password' => 'nullable|string|confirmed|min:6',
        ];
        $this->validate($request, $rules);

        $data = [
            'name' => $request->name,
        ];
        if (!empty($request->password)) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($request->only($data));

        session()->flash('success', '个人资料更新成功！');
        return redirect()->route('users.show', [$user]);
    }
}

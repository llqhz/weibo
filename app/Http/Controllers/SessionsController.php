<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ];
        $this->validate($request, $rules);

        // 验证用户是否登录成功
        if (Auth::attempt($request->only('email', 'password'), $request->has('remember'))) {
            // 登录成功
            session()->flash('success', '欢迎回来！');
            return redirect()->route('home', [Auth::user()]);
        } else {
            // 登录失败
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
            return redirect()->back()->withInput();
        }
    }

    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '您已成功退出！');
        return redirect('login');
    }
}

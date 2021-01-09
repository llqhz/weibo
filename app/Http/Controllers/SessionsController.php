<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    public function __construct()
    {
        // 只让未登录的用户访问注册和登录页
        $this->middleware('guest', [
            'only' => [
                'create',
            ],
        ]);
    }

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
            if (Auth::user()->activated) {
                // 如果邮箱已经验证通过
                session()->flash('success', '欢迎回来！');

                // 尝试跳转到登录之前的页面
                $fallback = route('home', [Auth::user()]);
                return redirect()->intended($fallback);
            } else {
                // 如果邮箱未被验证
                Auth::logout();
                session()->flash('warning', '你的账号未激活，请检查邮箱中的注册邮件进行激活。');
                return redirect('/');
            }
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
        return redirect()->route('login');
    }
}

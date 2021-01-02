<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            // 登录后才能访问页面
            'expect' => [
                // 已登录用户不能访问
                // 'show', // 展示用户详情
                'create', // 创建用户页面
                'store', //  创建用户提交
                'index',
            ],
        ]);

        $this->middleware('guest', [
            // 不用登录可以访问的页面
            'only' => [
                // 只能未登录用户访问
                'create', // 创建用户页面
                'store', //  创建用户提交
            ],
        ]);
    }

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
        $this->authorize('update', $user);

        return view('users.edit', compact('user'));
    }


    /**
     * 更新用户个人信息
     */
    public function update(User $user, Request $request)
    {
        $this->authorize('update', $user);

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
        $user->update($data);

        session()->flash('success', '个人资料更新成功！');
        return redirect()->route('users.show', [$user]);
    }

    /**
     * 用户列表(可匿名访问)
     */
    public function index()
    {
        $users = User::query()->paginate(10);

        return view('users.index', compact('users'));
    }

    public function destroy(User $user)
    {
        $this->authorize('destroy', $user);

        $user->delete();

        session()->flash('success', '成功删除用户！');
        return redirect()->back();
    }
}

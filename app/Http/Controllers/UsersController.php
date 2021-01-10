<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except([
            'show', // 展示用户详情
            'create', // 创建用户页面
            'store', //  创建用户提交
            'index', // 用户列表
            'confirmEmail', // 确认邮箱(无需登录)
        ]);

        $this->middleware('guest')->only([
            // 只能未登录用户访问
            'create', // 创建用户页面
            'store', //  创建用户提交
        ]);
    }

    public function create()
    {
        return view('users/create');
    }

    public function show(User $user)
    {
        // 获取用户的附属资源
        $statuses = $user->statuses()->orderBy('updated_at','desc')->paginate(10);

        return view('users/show', compact('user', 'statuses'));
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

        // 注册成功则发送邮件
        $this->sendEmailConfirmationToUser($user);
        session()->flash('success', '验证邮件已发送到你的注册邮箱上，请注意查收。');
        return redirect()->route('home');
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

    public function sendEmailConfirmationToUser(User $user)
    {
        $view = 'emails.confirm';
        $data = compact('user');
        $to = $user->email;
        $subject = "感谢注册 Weibo 应用！请确认你的邮箱。";

        Mail::send($view, $data, function (Message $message) use ($to, $subject) {
            $message->to($to)->subject($subject);
        });
    }

    public function confirmEmail($token)
    {
        /**
         * @var $user User
         */
        $user = User::query()->where('activation_token', $token)->firstOrFail();

        $user->activated = true;
        $user->activation_token = null;
        $user->save();

        Auth::login($user, false);
        session()->flash('success', '恭喜你，激活成功！');
        return redirect()->route('users.show', [$user]);
    }
}

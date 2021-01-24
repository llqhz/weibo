<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowersController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(User $user)
    {
        /* @var $currentUser User */
        $currentUser = Auth::user();

        $this->authorize('follow', $user);

        if (!$currentUser->isFollowing($user)) {
            $currentUser->follow($user);
        }

        session()->flash('success', '关注成功! ');
        return redirect()->route('users.show', [$user]);
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(User $user)
    {
        /* @var $currentUser User */
        $currentUser = Auth::user();

        // 判断权限
        $this->authorize('follow', $user);

        // 是否已关注
        if ($currentUser->isFollowing($user)) {
            $currentUser->unfollow($user);
        }

        session()->flash('success', '取消关注成功! ');
        return redirect()->route('users.show', [$user]);
    }
}

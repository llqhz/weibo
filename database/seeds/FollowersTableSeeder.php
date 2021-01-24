<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class FollowersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 第一个用户对除自己以外的用户进行关注，接着再让所有用户去关注第一个用户
        /* @var $me User */
        $me = User::query()->where('name', '筱怪')->first();

        $users = User::getUsersExceptMe($me->name);
        $me->follow($users->pluck('id')->toArray());

        $users->each(function (User $user) use ($me) {
            $user->follow($me->id);
        });
    }
}

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Status;
use Faker\Generator as Faker;
use App\Models\User;

// 查询用户Id
$users = User::getUsersWithMe('筱怪', 3);
$user_ids = $users->pluck('id');

$factory->define(Status::class, function (Faker $faker) use ($user_ids) {
    return [
        // 定义填充字段
        'content' => $faker->text(),
        'user_id' => $user_ids->random(),
        'created_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
        'updated_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
    ];
});

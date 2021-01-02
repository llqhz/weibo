<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @uses php artisan db:seed --class=UsersTableSeeder
     * @return void
     */
    public function run()
    {
        $users = factory(User::class)->times(50)->make();

        User::query()->insert($users->makeVisible(['password', 'remember_token'])->toArray());
    }
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * usage: php artisan db:seed
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call([
            UsersTableSeeder::class,
            StatusesTableSeeder::class,
            FollowersTableSeeder::class,
        ]);

        Model::reguard();
    }
}

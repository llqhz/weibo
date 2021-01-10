<?php

use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 初始化动态
        $statuses = factory(Status::class)->times(100)->make();

        Status::query()->insert($statuses->toArray());
    }
}

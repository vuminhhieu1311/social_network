<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        User::factory(200)->hasProfile()->hasPosts(5)->create();
//        Comment::factory(2)->create();
        Room::factory(5)->create();
    }
}

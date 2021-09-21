<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 50)->create();
        /* or you can add also another table that is dependent on user_id:*/
       factory(App\User::class, 10)->create()->each(function($u) {
            $userId = $u->id;
            DB::table('posts')->insert([
                'body' => str_random(100),
                'user_id' => $userId,
            ]);
        });
    }
}

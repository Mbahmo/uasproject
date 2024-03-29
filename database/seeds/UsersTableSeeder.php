<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "Anthony Lee",
            'email' => 'anthonyleembahmo@gmail.com',
            'password' => bcrypt('mantabmantab'),
            'image' => 'profile.png',
        ]);

        factory(User::class, 100)->create();
    }
}

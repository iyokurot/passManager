<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $def_pass = config('defaultUser.default_pass');
        $pass = hash('sha256', $def_pass);
        \DB::table('u_users')->insert([
            [
                'password' => $pass
            ]
        ]);
    }
}

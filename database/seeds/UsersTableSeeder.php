<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
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
            'resource_name' => 'admin',
            'parexel_user_id' => 'admin',
            'email' => 'admin@pxl.com',
            'mobile' => '9923112390',
            'role' => 'admin',
            'level' => 5,
            'password' => Hash::make('admin'),
        ]);
    }
}

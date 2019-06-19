<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
          'name' => 'admin123',
          'username' => 'admin123',
          'email' => 'admin123@wikicric.com',
          'password' => bcrypt('admin123'),
        ]);
    }
}

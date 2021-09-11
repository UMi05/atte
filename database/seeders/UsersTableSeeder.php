<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        $param = [
            'id' => '1',
            'name' => 'a',
            'email' => 'test-1@via.tokyo.jp',
            'password' => Hash::make('test')
        ];
        DB::table('users')->insert($param);

        $param = [
            'id' => '2',
            'name' => 'b',
            'email' => 'test-2@via.tokyo.jp',
            'password' => Hash::make('test')
        ];
        DB::table('users')->insert($param);

        $param = [
            'id' => '3',
            'name' => 'c',
            'email' => 'test-3@via.tokyo.jp',
            'password' => Hash::make('test')
        ];
        DB::table('users')->insert($param);

    }
}

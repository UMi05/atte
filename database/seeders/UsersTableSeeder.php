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
            'name' => '1',
            'email' => 'test-1@via.tokyo.jp',
            'password' => Hash::make('test')
        ];
        DB::table('users')->insert($param);

        $param = [
            'id' => '2',
            'name' => '2',
            'email' => 'test-2@via.tokyo.jp',
            'password' => Hash::make('test')
        ];
        DB::table('users')->insert($param);

        $param = [
            'id' => '3',
            'name' => '3',
            'email' => 'test-3@via.tokyo.jp',
            'password' => Hash::make('test')
        ];
        DB::table('users')->insert($param);

        $param = [
            'id' => '4',
            'name' => '4',
            'email' => 'test-4@via.tokyo.jp',
            'password' => Hash::make('test')
        ];
        DB::table('users')->insert($param);

        $param = [
            'id' => '5',
            'name' => '5',
            'email' => 'test-5@via.tokyo.jp',
            'password' => Hash::make('test')
        ];
        DB::table('users')->insert($param);

        $param = [
            'id' => '6',
            'name' => '6',
            'email' => 'test-6@via.tokyo.jp',
            'password' => Hash::make('test')
        ];
        DB::table('users')->insert($param);
    }
}

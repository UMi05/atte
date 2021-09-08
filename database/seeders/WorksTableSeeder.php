<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorksTableSeeder extends Seeder
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
            'user_id' => '1',
            'start_work' => '9:00:00',
            'end_work' => '17:00:00',
            'attendance_date' => '2021-08-29'
        ];
        DB::table('works')->insert($param);

        $param = [
            'id' => '2',
            'user_id' => '2',
            'start_work' => '8:00:00',
            'end_work' => '18:00:00',
            'attendance_date' => '2021-08-29'
        ];
        DB::table('works')->insert($param);
    }
}

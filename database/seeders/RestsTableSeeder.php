<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RestsTableSeeder extends Seeder
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
            'work_id' => '1',
            'start_rest' => '12:00:00',
            'end_rest' => '13:00:00',
        ];
        DB::table('rests')->insert($param);

        $param = [
            'id' => '2',
            'work_id' => '1',
            'start_rest' => '15:00:00',
            'end_rest' => '16:00:00',
        ];
        DB::table('rests')->insert($param);
    }
}

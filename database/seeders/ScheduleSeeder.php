<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // add some default events for the Tester user
        DB::Table('schedules')->insert([ // longevity awards
            'year'        => config('constants.srdd_year'),
            'user_id'     => 2, // this is the ID of the tester user
            'session_id'  => 1,
        ]);
        DB::Table('schedules')->insert([ // Lunch
            'year'        => config('constants.srdd_year'),
            'user_id'     => 2, // this is the ID of the tester user
            'session_id'  => 2,
        ]);
        DB::Table('schedules')->insert([ // Chancellor
            'year'        => config('constants.srdd_year'),
            'user_id'     => 2, // this is the ID of the tester user
            'session_id'  => 3,
        ]);
        DB::Table('schedules')->insert([ // Keynote
            'year'        => config('constants.srdd_year'),
            'user_id'     => 2, // this is the ID of the tester user
            'session_id'  => 4,
        ]);
    }
}

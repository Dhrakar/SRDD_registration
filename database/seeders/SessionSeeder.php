<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // add a couple of default sessions
        DB::Table('sessions')->insert([
            'event_id'   => 1, // longevity awards
            'venue_id'   => 3, // Wood Center Ballroom
            'slot_id'    => 3, // 10 - 11 am
            'url'        => 'https://uaf.edu/',
            'date_held'  => config('constants.db_srdd_date'),
            'start_time' => null,
            'end_time'   => null,
            'is_closed'  => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::Table('sessions')->insert([
            'event_id'   => 3, // Lunch
            'venue_id'   => 3, // Wood Center Ballroom
            'slot_id'    => 5, // 12 - 1 pm
            'url'        => null,
            'date_held'  => config('constants.db_srdd_date'),
            'start_time' => null,
            'end_time'   => null,
            'is_closed'  => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::Table('sessions')->insert([
            'event_id'   => 2, // Chancellor
            'venue_id'   => 3, // Wood Center Ballroom
            'slot_id'    => 2, // 9 - 10 am
            'url'        => null,
            'date_held'  => config('constants.db_srdd_date'),
            'start_time' => null,
            'end_time'   => null,
            'is_closed'  => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::Table('sessions')->insert([
            'event_id'   => 5, // Keynote
            'venue_id'   => 3, // Wood Center Ballroom
            'slot_id'    => 4, // 11 - 12 am
            'url'        => null,
            'date_held'  => config('constants.db_srdd_date'),
            'start_time' => null,
            'end_time'   => null,
            'is_closed'  => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

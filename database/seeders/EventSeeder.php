<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // add a couple of default events
        DB::Table('events')->insert([
            'track_id' => 1,
            'user_id' => 0,
            'year' => config('constants.srdd_year'),
            'title' => 'Longevity Awards',
            'description' => 'Staff recognition for UA employment milestones: 5,10,15,20,25,30,35,40,45 and 50 years.',
            'need_reg' => false,
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);
        DB::Table('events')->insert([
            'track_id' => 1,
            'user_id' => 0,
            'year' => config('constants.srdd_year'),
            'title' => "Chancellor's Presentation",
            'description' => 'Presentation from the Chancellor + Cornerstone and other special awards.',
            'need_reg' => false,
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);
        DB::Table('events')->insert([
            'track_id' => 1,
            'user_id' => 0,
            'year' => config('constants.srdd_year'),
            'title' => 'Lunch',
            'description' => 'Meal provided for the attendees to enjoy while gathering together.',
            'need_reg' => true,
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);
        DB::Table('events')->insert([
            'track_id' => 1,
            'user_id' => 0,
            'year' => config('constants.srdd_year'),
            'title' => 'Coffee, Tea and Goodies',
            'description' => 'Morning meal provided for the attendees to enjoy while gathering together.',
            'need_reg' => true,
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);
        DB::Table('events')->insert([
            'track_id' => 1,
            'user_id' => 0,
            'year' => config('constants.srdd_year'),
            'title' => 'Keynote',
            'description' => 'Presentation to UAF staff by an invited speaker.',
            'need_reg' => false,
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);
    }
}

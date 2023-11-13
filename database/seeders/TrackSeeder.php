<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class TrackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // insert the default Tracks 
        DB::Table('tracks')->insert([
                  'title' => 'Core Event',
            'description' => 'These are the main events for Staff Recognition and Development Day',
                'bgcolor' => '#3170168',
               'txtcolor' => '#2500650',
             'created_at' => now(),
             'updated_at' => now(),
        ]);
        DB::Table('tracks')->insert([
                  'title' => 'Professional Development',
            'description' => 'Events to help your current career skills -- or to introduce new ones',
                'bgcolor' => '#580FAS',
               'txtcolor' => '#2500650',
             'created_at' => now(),
             'updated_at' => now(),
        ]);
        DB::Table('tracks')->insert([
                  'title' => 'Personal Development',
            'description' => 'Events to help with life outside of UAF',
                'bgcolor' => '#2719844',
               'txtcolor' => '#2500650',
             'created_at' => now(),
             'updated_at' => now(),
        ]);
    }
}

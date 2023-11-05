<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class SlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // insert the default Slots 
        DB::Table('slots')->insert([
            'title'      => 'Welcome',
            'start_time' => '09:00:00',
            'end_time'   => '10:00:00',
        ]);
        DB::Table('slots')->insert([
            'title'      => 'Longevity',
            'start_time' => '10:00:00',
            'end_time'   => '11:00:00',
        ]);
        DB::Table('slots')->insert([
            'title'      => 'Keynote',
            'start_time' => '11:00:00',
            'end_time'   => '12:00:00',
        ]);
        DB::Table('slots')->insert([
            'title'      => 'Lunch',
            'start_time' => '12:00:00',
            'end_time'   => '13:00:00',
        ]);
        DB::Table('slots')->insert([
            'title'      => 'Breakout Session 1',
            'start_time' => '13:00:00',
            'end_time'   => '14:00:00',
        ]);
        DB::Table('slots')->insert([
            'title'      => 'Breakout Session 2',
            'start_time' => '14:00:00',
            'end_time'   => '15:00:00',
        ]);
        DB::Table('slots')->insert([
            'title'      => 'Breakout Session 3',
            'start_time' => '15:00:00',
            'end_time'   => '16:00:00',
        ]);
        DB::Table('slots')->insert([
            'title'      => 'Closing',
            'start_time' => '16:00:00',
            'end_time'   => '17:00:00',
        ]);
    }
}

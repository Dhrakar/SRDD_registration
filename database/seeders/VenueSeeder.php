<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class VenueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::Table('venues')->insert([
            'location'  => 'To Be Determined...',
            'max_seats' => -1,
        ]);
        DB::Table('venues')->insert([
            'location'  => 'Online Live Stream',
            'max_seats' => -1,
        ]);
        DB::Table('venues')->insert([
            'location'  => 'Wood Center Ballroom',
            'max_seats' => 349,
        ]);
        DB::Table('venues')->insert([
            'location'  => 'Wood Center Mall Area',
            'max_seats' => 150,
        ]);
        DB::Table('venues')->insert([
            'location'  => 'Wood Center Conf. E/F',
            'max_seats' => 50,
        ]);
        DB::Table('venues')->insert([
            'location'  => 'Schaible Auditorium',
            'max_seats' => 250,
        ]);
        DB::Table('venues')->insert([
            'location'  => 'BP Design Theater',
            'max_seats' => 100,
        ]);
    }
}

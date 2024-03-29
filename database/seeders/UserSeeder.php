<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create the main root account
        DB::Table('users')->insert([
            'name'              => env('ROOT_NAME'),
            'email'             => env('ROOT_EMAIL'),
            'email_verified_at' => now(),
            'password'          => env('ROOT_HASH'), 
            'remember_token'    => Str::random(10),
            'created_at'        => now(),
            'updated_at'        => now(),
            'last_login'        => now(),
            'level'             => 9, // root level
            'login_count'       => 1, 
        ]);
        // create the test account
        DB::Table('users')->insert([
            'name'              => env('TESTER_NAME'),
            'email'             => env('TESTER_EMAIL'),
            'email_verified_at' => now(),
            'password'          => env('TESTER_HASH'), 
            'remember_token'    => Str::random(10),
            'created_at'        => now(),
            'updated_at'        => now(),
            'last_login'        => now(),
            'level'             => 1, // attendee level
            'login_count'       => 1, 
        ]);
    }
}
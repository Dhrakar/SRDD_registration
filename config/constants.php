<?php

return [

    /*
    |---------------------------------------------------------------------------
    | This file contains the constants and enumerations used by this application
    |---------------------------------------------------------------------------
    |
    | 
    */
    
    // date of SRDD
    'srdd_date' => '10 April 2024',
    'srdd_year' => 2024,

    // User authorizatio levels
    'auth_level' => [
        0 => 'guest',
        1 => 'attendee',
        5 => 'admin',
        9 => 'root'
    ],

    // default colors
    'colors' => [
         'uaf' => [
            // primary colors
            'blue' => '#236192',
            'yellow' => '#FFC000',      
         ],
         'tracks' => [
            'no-color', // to force array to start with 1
            // array of possible colors for the track backgrounds. Note that any updates here
            // need to be mirrored in the hidden swatches in the header.blade.php file so that 
            // Tailwind.css does not filter out the colors.
            'bg-sky-400',
            'bg-emerald-400',
            'bg-amber-400',
            'bg-indigo-400',
            'bg-slate-400',
            'bg-red-400',
            'bg-orange-400',
            'bg-teal-400',
         ],
    ],
    // default botstrap icons
    'icon' => [
        'home' => 'bi-house-door',
        'user' => 'bi-person-circle',
        'guest' => 'bi-person-fill-slash',
    ],
];
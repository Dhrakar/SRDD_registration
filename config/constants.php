<?php

use Illuminate\Support\Carbon; // date object

return [

    /*
    |---------------------------------------------------------------------------
    | This file contains the constants and enumerations used by this application
    |---------------------------------------------------------------------------
    |
    | 
    */
    

    // date of SRDD
       'srdd_date' => env("SRD_DAY", now()),
    'db_srdd_date' => Carbon::parse(env("SRD_DAY", now()))->format('Y-m-d'),
   'fmt_srdd_date' => Carbon::parse(env('SRD_DAY', now()))->toFormattedDateString(),
       'srdd_year' => Carbon::parse(env("SRD_DAY", now()))->format('Y'),

    // User authorization levels
    'auth_level' => [
           'guest' => 0,
        'attendee' => 1,
           'admin' => 5,
            'root' => 9,
    ],

    // application defaults
             'ua_passwd' => env('UA_DEF_PASSWD'),
   'ua_google_client_id' => env('UA_CLIENT_ID'),

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
         'tracks_css' => [ // CSS color values for default track colors from the TW classes
            '#0f172a', // this corresponds to slate-400. not a track color, ut a backgrnd for online
            '#38bdf8',
            '#34d399',
            '#fbbf24',
            '#818cf8',
            '#94a3b8',
            '#f87171',
            '#fb923c',
            '#2dd4bf',
         ],
    ],
    // default botstrap icons
    'icon' => [
        'home' => 'bi-house-door',
        'user' => 'bi-person-circle',
        'guest' => 'bi-person-fill-slash',
    ],
];
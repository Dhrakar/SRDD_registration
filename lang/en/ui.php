<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Factbook UI Language Text
    |--------------------------------------------------------------------------
    |
    | Language items for various bits of UI -- including tooltips, menus, labels
    | etc. 
    */

    'menu' => [
           'home' => 'Home',
          'about' => 'About SRDD',
          'admin' => 'Admin/Config',
       'schedule' => 'Add Sessions',
        'reports' => 'Reports',
         'define' => 'Field Definitions',
           'help' => 'Application Help',
       'nav-home' => [
              'profile' => 'My Account',
               'review' => 'My Schedule',
                'print' => 'Print',
                'email' => 'Email',
               'logout' => 'Log Out',
           ],
      'nav-admin' => [
                'tracks' =>'Tracks',
                'venues' => 'Locations',
                'slots' => 'Time Slots',
                'events' => 'Events',
                'sessions' => 'Sessions',
                'users' => 'User Accounts',
      ],
            'lib' => 'Included Packages',
          'login' => 'Please Login or Register',
    ],
    'link' => [
       'register' => 'Create New Non-UA Account',
    ], 
    'button' => [
           'save' => 'Save',
         'cancel' => 'Cancel',
         'delete' => 'Delete!',
         'update' => 'Save Changes',
      'new-track' => "Save New Track",
       'new-slot' => "Save New Time Slot",
      'new-event' => "Save New Event",
    'new-session' => "Save New Session",
      'new-venue' => "Save New Location",
    ],
    'markdown' => [
        // As these are rather longer, they pull in markdown text from files in 
        // the resources/md folder
          'about' => file_get_contents(resource_path('md/about.md')),
    'boilerplate' => file_get_contents(resource_path('md/uaf_legal.md')),
         'gsuite' => file_get_contents(resource_path('md/gsuite_dialog.md')),
        'welcome' => file_get_contents(resource_path('md/welcome_txt.md')),
      'libraries' => file_get_contents(resource_path('md/app_packages.md')),
        
    ],
    'auth' => [
         'uafail' => 'Please click Cancel and use the Sign in With Google widget to login with a UA domain account',
    ],
];
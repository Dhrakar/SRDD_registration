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
          'about' => 'About SRDD',
          'admin' => 'Admin/Config',
         'define' => 'Field Definitions',
           'help' => 'Application Help',
           'home' => 'Home',
            'lib' => 'Included Packages',
          'login' => 'Not Logged In',
        'reports' => 'Reports',
       'schedule' => 'Add/View Sessions',
       'nav-home' => [
              'profile' => 'My Account',
               'review' => 'My Schedule',
                'print' => 'Print Schedule',
                'email' => 'Email Schedule',
               'logout' => 'Log Out',
           ],
      'nav-admin' => [
               'events' => 'Events',
             'sessions' => 'Sessions',
                'slots' => 'Time Slots',
               'tracks' => 'Tracks',
                'users' => 'User Accounts',
               'venues' => 'Locations',
      ],
    ],
    'link' => [
       'register' => 'Create New Non-UA Account',
    ], 
    'button' => [
         'cancel' => 'Cancel',
         'delete' => 'Delete!',
      'new-event' => "Save New Event",
    'new-session' => "Save New Session",
       'new-slot' => "Save New Time Slot",
      'new-track' => "Save New Track",
      'new-venue' => "Save New Location",
           'save' => 'Save',
         'update' => 'Save Changes',
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
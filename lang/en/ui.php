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
       'register' => 'Session Registration',
        'reports' => 'Reports',
         'define' => 'Field Definitions',
           'help' => 'Application Help',
           'home' => 'Home',
            'lib' => 'Included Packages',
          'login' => 'Please Login',
    ],
    'button' => [
           'save' => 'Save',
         'cancel' => 'Cancel',
         'update' => 'Save Changes',
      'new-track' => "Save New Track",
       'new-slot' => "Save New Time Slot",
      'new-event' => "Save New Event",
    'new-session' => "Save New Session",
      'new-venue' => "Save New Location",
         'delete' => 'Delete!',
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
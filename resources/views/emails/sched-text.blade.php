<?php
    // get user info
    $_usr = Illuminate\Support\Facades\Auth::user(); 
    // reformat the SRDD date
    $_date = Illuminate\Support\Carbon::parse(env('SRD_DAY', now()))->toFormattedDateString();

    // print out the email message
    print "Hello $_usr->name,\n"
        . "  Here is your schedule of events for the $_date Staff Recognition and Development Day:\n\n";
    printf(" %-5s  %-5s   %-39s   %-39s   %s\n", "Start", "End", "Location", "Track", "Event"); 
    foreach ($events->sortBy('start_time') as $event) {
        printf(" %-5s  %-5s  %-40s  %-40s  %s\n", 
            substr($event['start_time'],0,5), 
            substr($event['end_time'],0,5), 
            $event['location'], 
            $event['track'], 
            $event['title']
        );
    }
    print "\n"
        . "  If you have any comments or questions about these events or about SRDD in general, please"
        . " email the committee at UAF-Staff-SRDD@alaska.edu\n"
        . "\n"
        . "Regards, \n"
        . "  UAF SRDD Committee\n";
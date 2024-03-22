<?php     

    /**
     * Custom helper functions for this app 
     */

    // emits the ordinal version of a number
    if(! function_exists('ordinal')) {
        function ordinal($number) {
            $ends = array('th','st','nd','rd','th','th','th','th','th','th');
            if ((($number % 100) >= 11) && (($number%100) <= 13))
                return $number. 'th';
            else
                return $number. $ends[$number % 10];
        }
    }
?>
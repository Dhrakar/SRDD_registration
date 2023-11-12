<?php 
    /*
     *  All about this application
     */

    use function Laravel\Folio\name;
 
    name('about');

 ?>
@extends('template.app')

@section('content')

    <h1>
        About This Application
    </h1>
    <div class="callout">
        
        <em>Staff Recognition &amp; Development Day</em> is a time for us to recognize and thank the hard work done by UAF staff throughout the year.
	    It is also an opportunity to celebrate some longevity milestones for our staff.  Lastly, it is a day for staff to be able
	    to participate in fun training and informational sessions that can help in their personal and professional development.
	    <br/>
	    This web application was created to enable UAF employees to easily view and register for those training and event sessions. It
	    consists of 3 modules
	    <ol>
	        <li>Registration</li>
	        <li>Reports</li>
	        <li>Administration</li>
	    </ol>

    </div>

@endsection

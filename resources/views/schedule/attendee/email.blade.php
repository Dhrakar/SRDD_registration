<?php 

    use Illuminate\Support\Facades\Auth;
    use App\Http\Controllers\SchedulerController; 

    // current user
    $user = Auth::user();


    // get the event list for the schedule
    $_sched = new SchedulerController();
    $_events = $_sched->get_schedule($user);

    dd($_events);
?>
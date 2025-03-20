<?php 
    /*
     *  Main SRDD reporting page
     */

    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Carbon;
    use App\Models\Session;
    use App\Models\Schedule;
    use App\Models\User;
    use App\Models\Event;
    

    $reg = DB::table('schedules')
        ->select(DB::raw('session_id as id, count(user_id) as cnt '))
        ->where('schedules.year', config('constants.srdd_year'))
        ->groupBy('session_id')
        ->get()
    ;
    $regArray = $reg->values()->toArray();
    $my_events = Auth::user()->events();

    // random user (not root and has alaska.edu email)
    if(Schedule::where('year', config('constants.srdd_year'))->count() > 0) {
        $r_user = User::where('email', 'like', '%@alaska.edu')
                      ->where('id', Schedule::where('year', config('constants.srdd_year'))
                                            ->get()
                                            ->unique('user_id')
                                            ->pluck('user_id')
                                            ->random()
                             )->get();
    }
 ?>
@extends('template.app')

@section('content')
<div class="container">
    <x-global.toolbar :icon="__('bi-file-earmark-ruled')"/>
    <x-srdd.callout :title="__('SRDD Reports')">
        <span>
            This section has reports on the registration and attendance for the events and sessions.  If you
            are leading any sessions, you will be able to see a list of the registered attendees and then 
            print that report.
            If you are logged in with an admin-level account, you will be able to get a report of the total
            number of attendees as well as pull a random attendee record for any door-prize giveaways.
        </span>
    </x-srdd.callout>
</div>
@endsection

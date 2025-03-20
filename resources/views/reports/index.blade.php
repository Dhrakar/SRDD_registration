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
    } else {
        $r_user = "NONE";
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

    {{-- Check for permission status to get to the requested session --}}
    @if(session('status') !== null)
        <x-srdd.error :title="__('Cannot Show Session')">
            Access to that session is not permitted since you are not logged in with an Admin level account or
            the instructor for that session.
        </x-srdd.error>
    @endisset

    {{-- Limit this part to just admins --}}
    @if(Auth::user()->level >= config('constants.auth_level')['admin'])

        <x-srdd.notice :title="config('constants.srdd_year') . ' ' . __('Registration Totals')">
            <span>
                <i class="bi bi-calendar text-emerald-800 dark:text-emerald-300"></i> &nbsp;
                There are {{ Session::all()->where('date_held', config('constants.db_srdd_date'))->count() }} total
                sessions for this year's SRDD.
                <br/>
                <i class="bi bi-check2-circle text-emerald-800 dark:text-emerald-300"></i> &nbsp;
                There are a total of {{ Schedule::where('year', config('constants.srdd_year'))->get()->unique('user_id')->count('user_id') }} accounts registered
                for sessions in the {{ config('constants.srdd_year') }} SRDD.
                <br/>
                <i class="bi bi-basket text-emerald-800 dark:text-emerald-300"></i> &nbsp;
                {{ Schedule::where('session_id', 2)->count('user_id') }} attendees are registered for lunch.
                <br/>
            </span>
        </x-srdd.notice>

        {{-- Pick a random user if there are any registered for this year --}}

        <x-srdd.success :title="__('User Selection')">
            @if($r_user === "NONE")
                none
            @else
                some
            @endif
        </x-srdd.success>


    @endif

</div>
@endsection

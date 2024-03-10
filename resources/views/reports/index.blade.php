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
    <x-srdd.notice :title="__('Registration Totals')">
        <span>
            <i class="bi bi-check2-circle text-emerald-800 dark:text-emerald-300"></i> &nbsp;
            There are a total of {{ Schedule::all()->unique('user_id')->count('user_id') }} accounts registered 
            for sessions in the {{ config('constants.srdd_year') }} SRDD.  
        </span>
    </x-srdd.notice>
    @if(Auth::user()->level >= config('constants.auth_level')['admin'])
        <x-srdd.dialog :title="__('Registration For All Sessions on ' . Carbon::parse(env('SRD_DAY', now()))->toFormattedDateString())">
            <table class="border-collapse border border-slate-800">
                <thead>
                    <tr>
                        <th class="table-header">ID</th>
                        <th class="table-header">Event Title</th>
                        <th class="table-header">Description</th>
                        <th class="table-header">Leader</th>
                        <th class="table-header">Attendees</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(Session::all()->where('date_held', config('constants.db_srdd_date')) as $session) {{-- iterate thru the defined sessions for this year --}}
                    <tr class="hover:bg-slate-400">
                        <td class="border border-indigo-500">{{ $session->id }}</td>
                        <td class="border border-indigo-500">{{ $session->event->title }}</td>
                        <td class="border border-indigo-500">{{ $session->event->description }}</td>
                        <td class="border border-indigo-500">
                            @if($session->event->user_id > 0) 
                                {{ $session->event->instructor->name }}
                            @else
                                &dash;
                            @endif
                        </td>
                        <td class="border border-indigo-500">
                            @foreach($regArray as $reg)
                                {{-- Only grab a total if this session has any schedule entries --}}
                                @if($reg->id == $session->id) 
                                    {{ $reg->cnt }} 
                                @endif
                            @endforeach
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </x-srdd.dialog>
    @endif

    <x-srdd.dialog :title="__('Registrations for events I am leading')">
        @if($my_events->count() == 0) 
            <x-srdd.notice>
                You are not the lead for any events.  If you should be, please contact the SRDD committee.
            </x-srdd.notice>
        @else
            @foreach($my_events->get() as $event) 

                <x-srdd.notice :title="__('Event # ' . $event->id . ' - ' . $event->title )">
                    @if($event->sessions()->count() == 0)
                        Your event has not been added to any sessions.
                    @else
                        @foreach($event->sessions()->get() as $my_sess)
                            Session # {{ $my_sess->id }} </br>
                            @if($my_sess->schedules()->count() == 0 )
                                Your Session has noone registered yet
                            @else 
                                @php
                                    // build an array of all the registered user IDs
                                    $usrArray = DB::table('schedules')
                                        ->select('user_id')
                                        ->where('year', config('constants.srdd_year'))
                                        ->where('session_id', $my_sess->id)
                                        ->get()
                                        ->toArray();
                                foreach($usrArray as $usr) {
                                    $userObj = User::where('id',$usr->user_id)->first()->toArray();
                                    echo $userObj['name'] . '&nbsp;' . $userObj['email'] . '</br>';
                                }
                                @endphp
                            @endif
                        @endforeach
                        <x-srdd.divider/>
                    @endif
                </x-srdd.notice>
            @endforeach
        @endif
    </x-srdd.dialog>
    
</div>
@endsection

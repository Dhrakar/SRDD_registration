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
    $r_user = User::whereNot('id', 1)->where('email', 'like', '%@alaska.edu')->get()->random();
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

    @if(session('status') !== null)
        <x-srdd.error :title="__('Cannot Show Session')">
            Access to that session is not permitted since you are not logged in with an Admin level account or
            the instructor for that session.
        </x-srdd.error>
    @endisset
    <x-srdd.notice :title="__('Registration Totals')">
        <span>
            <i class="bi bi-calendar text-emerald-800 dark:text-emerald-300"></i> &nbsp;
            There are {{ Session::all()->where('date_held', config('constants.db_srdd_date'))->count() }} total 
            sessions for this year's SRDD.
            <br/>
            <i class="bi bi-check2-circle text-emerald-800 dark:text-emerald-300"></i> &nbsp;
            There are a total of {{ Schedule::all()->unique('user_id')->count('user_id') }} accounts registered 
            for sessions in the {{ config('constants.srdd_year') }} SRDD.  
            <br/>
            <i class="bi bi-basket text-emerald-800 dark:text-emerald-300"></i> &nbsp;
            {{ Schedule::where('session_id', 2)->count('user_id') }} attendees are registered for lunch.
            <br/>
        </span>
    </x-srdd.notice>

    @if(Auth::user()->level >= config('constants.auth_level')['admin'])
        
        <x-srdd.success :title="__('User Selection')">
            Random registered user: {{ $r_user->name }} &lt;{{ $r_user->email }}&gt; 
            <a class="ml-2 pr-2 px-1 py-1 border bg-indigo-400 border-indigo-200 shadow-sm font-semibold text-xs text-std uppercase rounded-md" 
               href="{{route('reports')}}">
                <i class="bi bi-arrow-clockwise"></i>&nbsp;update
            </a>
        </x-srdd.success>

        <x-srdd.dialog :title="__('Registration For All Sessions on ' . Carbon::parse(env('SRD_DAY', now()))->toFormattedDateString())">
            <div class="mx-2 grid grid-cols-12 gap-0 auto-cols-max-12">
                <div class="px-2 table-header col-span-1">Id</div>
                <div class="px-2 table-header col-span-2">Event Title</div>
                <div class="px-2 table-header col-span-3">Description</div>
                <div class="px-2 table-header col-span-2">Presenter</div>
                <div class="px-2 table-header col-span-1"># Reg.</div>
                <div class="px-2 table-header col-span-2">Location</div>
                <div class="px-2 table-header col-span-1" data-tippy-content="Venue capacity - # Attendees">Seats</div>
                @foreach(Session::all()->where('date_held', config('constants.db_srdd_date')) as $session) {{-- iterate thru the defined sessions for this year --}}
                    <div class="table-row col-span-1">
                        <a href="{{ route('reports.session', $session) }}">
                            {{ $session->id }}
                        </a>
                    </div>
                    <div class="table-row col-span-2">
                        {{ $session->event->title ?? '---' }}
                    </div>
                    <div class="table-row col-span-3" data-tippy-content="{{ $session->event->description ?? '---' }}">
                        {{ substr($session->event->description,0,25) . '...' ?? '---' }}
                    </div>
                    <div class="table-row col-span-2">
                        @if($session->event->user_id > 0) 
                                {{ $session->event->instructor->name }}
                            @else
                                ---
                            @endif
                    </div>
                    <div class="table-row col-span-1">
                        @foreach($regArray as $reg)
                            {{-- Only grab a total if this session has any schedule entries --}}
                            @if($reg->id == $session->id) 
                                {{ $reg->cnt }} 
                            @endif
                        @endforeach
                    </div>
                    <div class="table-row col-span-2">
                        {{ $session->venue->location ?? '---' }}
                    </div>
                    <div class="table-row col-span-1">
                        @foreach($regArray as $reg)
                            {{-- Only grab a total if this session has any schedule entries --}}
                            @if($reg->id == $session->id && isset($session->venue->max_seats)) 
                                {!! ($session->venue->max_seats == -1)?'<i class="bi bi-infinity"></i>':$session->venue->max_seats - $reg->cnt !!} 
                            @endif
                        @endforeach
                    </div>
                @endforeach
            </div>
        </x-srdd.dialog>
    @endif

    @if($my_events->count() == 0) 
        <x-srdd.notice>
            You are not the lead for any events.  If you should be, please contact the SRDD committee.
        </x-srdd.notice>
    @else
        <x-srdd.dialog :title="__('Registrations for events I am leading')">

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
                                        $_regNo = 1;
                                        $_usrColl = Schedule::where('year', config('constants.srdd_year'))->where('session_id', $my_sess->id)->get()->pluck('user_id');
                                    @endphp
                                    <div class="ml-2 font-sans text-base text-gray-900">
                                        <table class="w-full table-fixed border-collapse" >
                                            <thead>
                                                <tr class="table-header">
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Email Address</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                              {{-- Check to see if there are actually any registrations --}}
                                              @if($_usrColl->count() < 1)
                                              <tr class="table-row">
                                                <td colspan="3">There are no registered attendees for this session</td>
                                              </tr>
                                              @else
                                              @foreach($_usrColl as $_usr)  
                                                @php
                                                    // get User object for this id (use first() so that there is only 1 item in collection)
                                                    $_usrObj = User::where('id',$_usr)->first(); 
                                                @endphp
                                                {{-- If this object is not null, then continue --}}
                                                @if($_usrObj !== null)
                                                    <tr class="table-row">
                                                        <td>{{ $_regNo++ }}</td>
                                                        <td>{{ $_usrObj->name  }}</td>
                                                        <td>{{ $_usrObj->email }}</td>
                                                    </tr>
                                                @endif
                                              @endforeach
                                              @endif
                                            </tbody>
                                        </table>
                                    </div> 
                                    <div class="flex gap-2 h-8 pl-4 mt-4">
                                        <a class="ml-8 px-4 py-2 
                                                bg-green-500 border border-green-300 rounded-md 
                                                font-semibold text-xs text-std uppercase tracking-widest 
                                                shadow-sm hover:green-50
                                                disabled:opacity-25 transition ease-in-out duration-150"
                                            href="{{route('reports.session', $my_sess)}}">
                                            <i class="bi bi-search"></i>
                                            {{__('Get Session Details')}}
                                        </a>   
                                    </div>
                                @endif
                            @endforeach
                            <x-srdd.divider/>
                        @endif
                    </x-srdd.notice>
                @endforeach
        </x-srdd.dialog>
    @endif
</div>
@endsection

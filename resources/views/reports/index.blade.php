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

        <x-srdd.notice :title="config('constants.srdd_year') . ' ' . __('Registration Overview')">
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
                <i class="bi bi-people text-emerald-800 dark:text-emerald-300"></i> &nbsp;
                Random registered user: &nbsp;
                @if($r_user === "NONE")
                    <span>No users are registered for sessions yet thie year</span>
                @else
                    <span>
                        {{ $r_user[0]->name . " <" . $r_user[0]->email . ">" }}
                        <a class="ml-2 pr-2 px-1 py-1 border bg-indigo-400 border-indigo-200 shadow-sm font-semibold text-xs text-std uppercase rounded-md"
                           href="{{route('reports')}}"
                        >
                            <i class="bi bi-arrow-clockwise"></i>Refresh
                        </a>
                    </span>
                @endif
            </span>
        </x-srdd.notice>

        {{-- Show the statuses and give links for all of this year's sessions --}}
        <x-srdd.dialog :title="__('Registration For All Sessions on ' . config('constants.fmt_srdd_date'))">
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

</div>
@endsection

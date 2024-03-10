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
    

    $res = DB::table('schedules')
        ->select(DB::raw('count(user_id) as reg, session_id'))
        ->where('schedules.year', 2024)
        ->groupBy('session_id')
        ->get()
    ;
    // dd(User::all()->whereNotIn('id',[1])->random()->name);
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
                            {{ $res->where('session_id', $session->id)->first()->reg }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </x-srdd.dialog>
    @endif
</div>
@endsection

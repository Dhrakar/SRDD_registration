<?php
    /**
     * Prints out the session report
     */
    
    
    use Illuminate\Support\Carbon;
    use App\Models\Schedule;
    use App\Models\User;

    // reformat the SRDD date
    $_date = config('constants.fmt_srdd_date');
    // Calculated number for each attendee 
    $_regNo = 1;
    // build an collection of the userIDs for this session (if any)
    $_usrColl = Schedule::where('year', config('constants.srdd_year'))->where('session_id', $session->id)->get()->pluck('user_id');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>{{ config('app.name', 'Application') }}</title>
        {{-- Meta tags, CSS and JS libraries --}}
        <x-global.header/>
    </head>
    <main>
        <div class="container">
            <div class="mx-8 mt-2text-xxxl font-bold">
                {{ $_date }} Staff Recognition &amp; Development Day 
            </div>
            <table class="w-1/3 mt-4 ml-2 table-fixed border-collapse border border-slate-800">
                <tr>
                    <th class="px-2 text-right">Session Number</th>
                    <td class="px-2 text-left">{{$session->id}}</td>
                </tr>
                <tr>
                    <th class="px-2 text-right">Session Event</th>
                    <td class="px-2 text-left">{{$session->event->title}}</td>
                </tr>
                <tr>
                    <th class="px-2 text-right">Session Instructor</th>
                    <td class="px-2 text-left">
                    @if($session->event->user_id > 0)
                        {{ $session->event->instructor->name }} &nbsp; &lt;<span id="emailCopyText">{{ $session->event->instructor->email }}</span>&gt;
                    @else
                        No Instructor/Lead for this session.
                    @endif</td>
                </tr>
                <tr>
                    <th class="px-2 text-right">Session Date</th>
                    <td class="px-2 text-left">{{$session->date_held}}</td>
                </tr>
                <tr>
                    <th class="px-2 text-right">Session Time</th>
                    <td class="px-2 text-left">
                        {{ ( $session->slot->id == 1)?$session->start_time:$session->slot->start_time }} 
                        &dash; 
                        {{ ( $session->slot->id == 1)?$session->end_time:$session->slot->end_time }}
                    </td>
                </tr>
            </table>

            <div class="mt-4 pl-4 font-semibold">
                Attendees
            </div>
            <table class="w-1/2 mt-4 ml-2 table-fixed border-collapse border border-slate-800">
                <thead>
                <tr class="bg-slate-200">
                    <th>#</th>
                    <th>Name</th>
                    <th>Email Address</th>
                </tr>
                </thead>
                <tbody>
                    @if($_usrColl->count() < 1)
                        <tr>
                            <td colspan="3" class="border border-slate-600">
                                There are no registered attendees for this session
                            </td>
                        </tr>
                    @else
                        @foreach($_usrColl as $_usr)
                        @php
                            // get User object for this id (use first() so that there is only 1 item in collection)
                            $_usrObj = User::where('id',$_usr)->first(); 
                        @endphp
                        {{-- If this object is not null, then continue --}}
                        @if($_usrObj !== null)
                            <tr class="border border-slate-400">
                                <td>{{ $_regNo++ }}</td>
                                <td>{{ $_usrObj->name  }}</td>
                                <td>{{ $_usrObj->email }}</td>
                            </tr>
                        @endif
                        @endforeach
                    @endif
                </tbody>
            </table>
            <div class="flex gap-2 h-8 pl-4 mt-4">
                <a class="px-4 py-2 bg-emerald-500 border border-emerald-950 rounded-sm 
                       font-semibold text-xs text-gray-700 uppercase tracking-widest
                       shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 
                       focus:ring-indigo-500 focus:ring-offset-2 print:hidden"
                       id="printme" type="button" value="" 
                       onclick="window.print()"
                    href="#">
                    <i class="bi bi-printer-fill"></i> Print this page
                </a>
                <a  class="px-4 py-2 bg-sky-500 border border-sky-950 rounded-sm 
                           font-semibold text-xs text-gray-700 uppercase tracking-widest
                           shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 
                           focus:ring-indigo-500 focus:ring-offset-2 print:hidden"
                    href="{{route('reports.session', $session)}}">
                    <i class="bi bi-arrow-90deg-left"></i>Return to Session Report
                </a>
            </div>
        </div>
    </main>
</html>

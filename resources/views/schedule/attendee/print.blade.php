<?php
    /**
     * Print layout for the user's schedule.  It does not rely on the global header/footer so
     * that it an more easily be printed without the headers, etc.
     * 
     * @param $user
     */
    use Illuminate\Support\Carbon;
    use Illuminate\Support\Facades\Auth;
    use App\Http\Controllers\SchedulerController; 

    // current user
    $user = Auth::user();
    // format the srdd date for use with teh DATE field
    $srdd_date = config('constants.db_srdd_date'); 
    // reformat the SRDD date for the header
    $_date = Carbon::parse(env('SRD_DAY', now()))->format('jS \\of F, Y');
    // get the event list for the schedule
    $_sched = new SchedulerController();
    $_events = $_sched->get_sched_json($user);
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
                <div class="text-xl font-semibold text-slate-500 mx-8 mt-4">
                    Staff Recognition &amp; Development Day schedule for {{ $user->name }}
                </div>
                <div id="calendar" class="text-slate-500 mx-4 mb-4"></div>
                <div class="flex gap-2 h-8 pl-4">
                    <a  class="px-4 py-2 bg-sky-500 border border-sky-950 rounded-sm 
                               font-semibold text-xs text-gray-700 uppercase tracking-widest
                               shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 
                               focus:ring-indigo-500 focus:ring-offset-2 print:hidden"
                        href="{{route('schedule')}}">
                        <i class="bi bi-arrow-90deg-left"></i>Return to Schedule
                    </a>
                    {{-- check for any sessions for this user --}}
                    @if ($user->schedules->count() == 0) 
                        <span class="text-sm">
                            You do not have any events scheduled </br>
                        </span>
                    @else
                        <a class="px-4 py-2 bg-emerald-500 border border-emerald-950 rounded-sm 
                               font-semibold text-xs text-gray-700 uppercase tracking-widest
                               shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 
                               focus:ring-indigo-500 focus:ring-offset-2 print:hidden"
                               id="printme" type="button" value="" 
                               onclick="window.print()"
                            href="#">
                            <i class="bi bi-printer-fill"></i> Print this page
                        </a>
                    @endif
                </div>
            </div>

            {{-- Add all the current sessions to the calendar --}}
            <script> 
                window.onload = function () {
                    var calendarEl = document.getElementById('calendar');
                    var calendar = new Calendar(calendarEl, {
                        plugins: [listPlugin],
                        headerToolbar: {
                            left: '',
                            center: '',
                            right:  '',
                        },
                        height: 700,
                        initialView: 'listDay',
                        initialDate: '{{ $srdd_date }}',
                        slotMinTime: '6:00:00',
                        slotMaxTime: '21:00:00',
                        {!! $_events !!}
                    });
                    calendar.render();
                }
            </script>
        </main>
</html>
<?php
    /**
     * Print layout for the user's schedule.  It does not rely on the global header/footer so
     * that it an more easily be printed without the headers, etc.
     * 
     * @param $user
     */
    use Illuminate\Support\Carbon;
    use Illuminate\Support\Facades\Auth;
    // current user
    $user = Auth::user();
    // format the srdd date for use with teh DATE field
    $srdd_date = config('constants.db_srdd_date'); 
    // reformat the SRDD date for the header
    $_date = Carbon::parse(env('SRD_DAY', now()))->format('jS \\of F, Y');
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
                <div class="flex gap-2">
                    <a  class="px-4 py-2 bg-sky-500 border border-sky-950 rounded-sm 
                               font-semibold text-xs text-gray-700 uppercase tracking-widest
                               shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 
                               focus:ring-indigo-500 focus:ring-offset-2 print:hidden"
                        href="{{route('schedule')}}">Return to Schedule</a>
                    {{-- check for any sessions for this user --}}
                @if ($user->schedules->count() == 0) 
                <span class="text-sm">
                    You do not have any events scheduled </br>
                </span>
                @else
                    <input class="px-4 py-2 bg-emerald-500 border border-emerald-950 rounded-sm 
                           font-semibold text-xs text-gray-700 uppercase tracking-widest
                           shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 
                           focus:ring-indigo-500 focus:ring-offset-2 print:hidden"
                           id="printme" type="button" value="Print this page" 
                           onclick="window.print()"
                    />
                           
                    <input class="px-4 py-2 bg-emerald-500 border border-emerald-950 rounded-sm 
                           font-semibold text-xs text-gray-700 uppercase tracking-widest
                           shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 
                           focus:ring-indigo-500 focus:ring-offset-2 print:hidden"
                           id="emaiilme" type="button" value="Email your schedule" 
                           data-tippy-content="Not yet implemented"
                    />
                </div>
                <div class="text-xl font-semibold text-slate-500 mx-8 mt-4">
                    Staff Recognition &amp; Development Day is the {{ $_date }}
                </div>
                <div id="calendar" class="text-slate-500 mx-4 mb-4"></div>
                @endif
            </div>

            {{-- Add all the current sessions --}}
            <script> 
                window.onload = function () {
                    var calendarEl = document.getElementById('calendar');
                    var calendar = new Calendar(calendarEl, {
                        customButtons: {
                            srddButton: {
                                text: 'Return to SRDD',
                                click: function() {
                                    calendar.gotoDate('{{ $srdd_date }}');
                                }
                            }
                        },
                        plugins: [listPlugin],
                        headerToolbar: {
                            left: '',
                            center: '',
                            right:  '',
                        },
                        initialView: 'listDay',
                        initialDate: '{{ $srdd_date }}',
                        slotMinTime: '6:00:00',
                        slotMaxTime: '21:00:00',
                        {!! $events !!}
                    });
                    calendar.render();
                }
            </script>
        </main>
</html>
<?php
    // get user info
    $_usr = Illuminate\Support\Facades\Auth::user(); 
    // reformat the SRDD date
    $_date = Illuminate\Support\Carbon::parse(env('SRD_DAY', now()))->toFormattedDateString();
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>SRDD Schedule</title>
        <x-global.header/>
        <style>
            table {
                border-collapse: collapse;
                border: 1px solid #ddd;
                width: 80%;
            }
        </style>
    </head>
    <body>
        <div class="font-sans text-base text-gray-900">
            <div class="mb-8">
            Hello {{ $_usr->name }},<br/>
            &nbsp;Here is your schedule of events for the {{ $_date }} Staff Recognition and Development Day
            </div>
            <br/>
            <table>
                <thead >
                    <tr class="bg-slate-400">
                        <th class="border border-slate-700">Start</th>
                        <th class="border border-slate-700">End</th>
                        <th class="border border-slate-700">Location</th>
                        <th class="border border-slate-700">Track</th>
                        <th class="border border-slate-700">Event</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($events->sortBy('start_time') as $event)
                        <tr class="">
                            <td class="border border-slate-700 px-2">
                                {{ substr($event['start_time'],0,5) }}
                            </td>
                            <td class="border border-slate-700 px-2">
                                {{ substr($event['end_time'],0,5) }}
                            </td>
                            <td class="border border-slate-700 px-2">{{ $event['location'] }}</td>
                            <td class="border border-slate-700 px-2">{{ $event['track'] }}</td>
                            <td class="border border-slate-700 px-2">{{ $event['title'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <br/><br/>
            &nbsp;If you have any comments or questions about these events or about SRDD in general, please email 
            the committee at <a href="mailto:UAF-Staff-SRDD@alaska.edu">UAF-Staff-SRDD@alaska.edu</a>
            <br/><br/>
            Regards,<br/>
            &nbsp;UAF SRDD Committee
        </div>
    </body>
</html>
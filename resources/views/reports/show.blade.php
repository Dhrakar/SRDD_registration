<?php
    /**
     * Shows an individual session with all of the attendee information
     * 
     * Admin only
     */

    use App\Models\Event;
    use App\Models\Schedule;
    use App\Models\Session;
    use App\Models\User;

    // page variables for text color, etc
    $m_text_def  = "text-md text-slate-100 hover:text-teal-200";  // default menu text attributes 
    $m_text_sel  = "text-md font-semibold text-[#FFC000] ";  // test color when on that route
?>


@extends('template.app')
@section('content')
    <div class="container">
        <x-global.toolbar :icon="__('bi-file-earmark-ruled')">
            <li class="mx-6">
                <a  class="text-md {{ (strpos(url()->current(), 'print') !== false)?$m_text_sel:$m_text_def }}" 
                    href="{{route('reports.print', $session)}}">
                    <i class="bi bi-printer"></i>
                    {{__('Print Session Details')}}
                </a>
            </li>
        </x-global.toolbar>
        <x-srdd.title-box :title="__('Details for Session # ' . $session->id)">
            <div class="mx-1 grid grid-cols-6 auto-col-max-6 gap-0">
                {{-- Date when this session was held (could be hstorical) --}}
                <div class="col-span-1 table-header text-right pr-4">
                    Session Date
                </div>
                <div class="col-span-4 border border-indigo-800 text-std">
                    {{ $session->date_held }}
                </div>
                <x-srdd.row-comment class="col-span-1">
                </x-srdd.row-comment>
                   
                {{-- Start/end times Use session start/end if a custom time slot --}}
                <div class="col-span-1 table-header text-right pr-4">
                    Session Time 
                </div>
                <div class="col-span-4 border border-indigo-800 text-std">
                    {{ ( $session->slot->id == 1)?$session->start_time:$session->slot->start_time }} 
                    &dash; 
                    {{ ( $session->slot->id == 1)?$session->end_time:$session->slot->end_time }}
                </div>
                <x-srdd.row-comment class="col-span-1">
                    {{$session->slot->title}}
                </x-srdd.row-comment>   

                {{-- Title of the event for this session --}}
                <div class="col-span-1 table-header text-right pr-4">
                    Session Event
                </div>
                <div class="col-span-4 border border-indigo-800 text-std">
                    {{ $session->event->title }}
                </div>
                <x-srdd.row-comment class="col-span-1">
                </x-srdd.row-comment>     

                {{-- Event presentor (if any) --}}
                <div class="col-span-1 table-header text-right pr-4">
                    Session Instructor
                </div>
                <div class="col-span-3 border border-indigo-800 text-std">
                    @if($session->event->user_id > 0)
                        {{ $session->event->instructor->name }} &nbsp; &lt;<span id="emailCopyText">{{ $session->event->instructor->email }}</span>&gt;
                    @else
                    <i class="bi bi-person-slash"> &nbsp; No Instructor/Lead for this session.</i>
                    @endif
                </div>
                <div class="col-span-1 text-std">
                    @if($session->event->user_id > 0)
                        <button id="emailCopyButton" 
                             class=" ml-4 mt-1 px-2 bg-cyan-800 dark:bg-cyan-300 border border-cyan-900 hover:bg-slate-500 ">
                            Copy Email <i class="bi bi-clipboard"></i>
                        </button> 
                    @else
                    &nbsp;
                    @endif
                </div>
                <x-srdd.row-comment class="col-span-1">
                </x-srdd.row-comment>             
            </div>
            <div class="mt-6 ml-4 py-3">
            {{-- Now list all of the attendees --}}
              <div class="ml-2 w-1/2 text-lg text-std">
                Registered Attendees 
              </div>
                @php 
                    // Calculated number for each attendee 
                    $_regNo = 1;
                    // build an collection of the userIDs for this session (if any)
                    $_usrColl = Schedule::where('year', config('constants.srdd_year'))->where('session_id', $session->id)->get()->pluck('user_id');
                @endphp
                <div class="ml-2 font-sans text-base text-gray-900">
                    <table class="w-1/2 border-collapse" >
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
            </div>
            <a class="ml-8 mt-2 px-4 py-2 
                    bg-green-500 border border-green-300 rounded-md 
                    font-semibold text-xs text-std uppercase tracking-widest 
                    shadow-sm hover:green-50
                    disabled:opacity-25 transition ease-in-out duration-150"
                href="{{route('reports')}}">
                <i class="bi bi-calendar-check"></i>&nbsp;{{__('Return')}}
            </a>
      </x-srdd.title-box>
    </div>
    {{-- jQuery for email copy --}}
    <script>
        window.onload = function () {
            $('#emailCopyButton').click(function() {
                var myText = $('#emailCopyText').text();
                var tempText = $('<textarea>');
                $('body').append(tempText);
                tempText.val(myText).select();
                document.execCommand('copy');
                tempText.remove();
            });
        }
    </script>
@endsection

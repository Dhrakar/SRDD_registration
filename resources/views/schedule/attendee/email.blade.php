<?php 

    use Illuminate\Support\Facades\Auth;
    use App\Http\Controllers\SchedulerController; 

    // current user
    $user = Auth::user();


    // get the event list for the schedule
    $_sched = new SchedulerController();
    $_events = $_sched->get_schedule($user);

?>
@extends('template.app')

@section('content')
<div class="container">
    <x-global.toolbar >
        <li class="mx-6">
            <a  class="text-md text-slate-100 hover:text-teal-200"" 
                href="{{route('schedule')}}">
                <i class="bi bi-eyeglasses"></i>
                {{__('ui.menu.nav-home.review')}}
            </a>
        </li>
    </x-global.toolbar>
    <x-srdd.success :title="__('Schedule Sent')">
  Your schedule of events has been emailed to {{ $user->email }}
    </x-srdd.success>
    <a  class="m-4 px-4 py-2 bg-sky-500 border border-sky-950 rounded-sm 
            font-semibold text-xs text-gray-700 uppercase tracking-widest
            shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 
            focus:ring-indigo-500 focus:ring-offset-2 print:hidden"
        href="{{route('schedule')}}">
        <i class="bi bi-arrow-90deg-left"></i>Return to Schedule
    </a>

@endsection
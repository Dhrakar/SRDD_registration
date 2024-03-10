<?php 
    /*
     *  Main SRDD reporting page
     */

    use Illuminate\Support\Facades\Auth;
    use App\Models\Session;
 ?>
@extends('template.app')

@section('content')
<div class="container">
    <x-global.toolbar :icon="__('bi-file-earmark-ruled')"/>

    @if(Auth::user()->level >= config('constants.auth_level')['admin'])
        <x-srdd.dialog :title="__('Registration For All Sessions')">
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
                    @foreach(Session::all() as $session) {{-- iterate thru the defined sessions --}}
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
                        <td class="border border-indigo-500">27</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </x-srdd.dialog>
    @endif
</div>
@endsection

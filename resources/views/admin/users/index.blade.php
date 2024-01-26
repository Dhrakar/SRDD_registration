<?php 
    /**
     * Admin panel for the user accounts. Allows editing. For new users, it just calls Register
     */

     use App\Models\User;
?>

@extends('template.app')

@section('content')
<x-srdd.nav-admin/>
<div class="container w-full">
    <x-srdd.callout :title="__('User Accounts')">
        Here are all of the current user accounts that have logged in to this registration tool.  You can 
        edit them, assign admin privs, or lock these accounts.  For new accounts, use the Register page.
    </x-srdd.callout>
    {{-- List existing users --}}
    <x-srdd.title-box :title="__('Currently Configured Users')">
        <div class="mx-2 grid grid-cols-12 gap-0 auto-cols-max-12">
            <div class="px-2 table-header col-span-1">Id</div>
            <div class="px-2 table-header col-span-2">Name</div>
            <div class="px-2 table-header col-span-3">Email</div>
            <div class="px-2 table-header col-span-2">last Login</div>
            <div class="px-2 table-header col-span-1">Level</div>
            <div class="px-2 table-header col-span-1">Locked?</div>
            <div class="px-2 table-header col-span-1">Presenter?</div>
            <div class="px-2 table-header col-span-1">Edit</div>
            @foreach(User::all() as $user)
                <div class="px-2 table-row col-span-1">{{$user->id}}</div>
                <div class="px-2 table-row col-span-2">{{$user->name}}</div>
                <div class="px-2 table-row col-span-3">{{$user->email}}</div>
                <div class="px-2 table-row col-span-2">{{$user->last_login}}</div>
                <div class="px-2 table-row col-span-1">
                    {{ array_search($user->level, config('constants.auth_level')) }}
                </div>
                <div class="px-2 table-row col-span-1">
                    <i class=" bi bi-unlock mx-2"></i>
                </div>
                <div class="px-2 table-row col-span-1">
                    {{-- TODO: link to report for this presenter --}}
                    {{ ($user->events->count() > 0)?'Yes':'No' }}
                </div>
                @if($user->id == 1 ) {{-- don't allow root user to be edited or locked --}}
                    <div class="px-2 table-row col-span-1">
                        <i class="text-slate-400 bi bi-pencil-square mx-2"></i>
                    </div>
                @else
                    <div class="px-2 table-row col-span-1">
                        <a href="{{ route('users.edit', $user) }}">
                            <i class="bi bi-pencil-square mx-2"></i>
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
    </x-srdd.title-box>
</div>
@endsection
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

    {{-- Create a new user account --}}
    <x-srdd.title-box :title="__('Add a new User Account')">
        <x-srdd.warning >
            <span>
                Adding new users should only be done for presenters.  This process
                will create a new 'stub' user account that will have a random password.  A UA
                employee can later on login to this account <i>if</i></br>
                &nbsp;- The email you enter is their UA @alaska.edu address</br>
                &nbsp;- They use the Google UA login (which matches by email address)
                </br>Other non-UA users will need to use the <b>Forgot my Password</b> feature
                to reset their password using the email you entered.
            </span> 
        </x-srdd.warning>
        <form method="POST" action="{{ route('users.store') }}">
            @csrf
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
            <x-input-error :messages="$errors->get('level')" class="mt-2" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
            <div class="mx-1 grid grid-cols-6 auto-col-max-6 gap-0">
                {{-- set the name --}}
                <div class="col-span-1 table-header text-right pr-4">
                    <label for="title">Name of User</label>
                </div>
                <div class="col-span-4 border border-indigo-800">
                    <input class="text-slate-900 w-4/5 "
                        type="input" name="name" 
                        value="{{ old('name') }}" 
                        maxlength="50"
                        width="50"/>
                </div>
                <div class="col-span-1 text-xs text-red-600 italic pl-2">
                     50 chars max length
                </div>
                {{-- set the email --}}
                <div class="col-span-1 table-header text-right pr-4">
                    <label for="title">User's Email Address</label>
                </div>
                <div class="col-span-4 border border-indigo-800">
                    <input class="text-slate-900 w-4/5 "
                        type="input" name="email" 
                        value="{{ old('email') }}" 
                        maxlength="100"
                        width="100"/>
                </div>
                <div class="col-span-1 text-xs text-red-600 italic pl-2">
                     100 chars max length
                </div>
                {{-- set the level --}}
                <div class="col-span-1 table-header text-right pr-4">
                    <label for="title">User's Auth Level</label>
                </div>
                <div class="col-span-4 border border-indigo-800">
                    <select name="level" class="ml-1 mr-8">
                        <?php 
                          $levels = config('constants.auth_level');
                          foreach( $levels as $key => $val) {
                                if($key != 'root') { // don't show root for this dropdown
                                    echo "<option value='$val' >$key</option> \n";
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="col-span-1">&nbsp;</div>
                <x-primary-button class="col-span-1 mt-4 mx-2 justify-center">
                    {{ __('ui.button.new-user') }}
                </x-primary-button>
            </div>
        </form>
    </x-srdd.title-box>
    {{-- List existing users --}}
    <div class="overflow-y-auto">
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
</div>
@endsection
<?php
  /**
   *  This is used to edit Tracks
   */
$return_status = session('status');
?>
@extends('template.app')

@section('content')
<div class="container">
<x-srdd.nav-home/>
<x-srdd.callout :title="__('User Account Profile')">
    <span>
        Here is where you can edit avaialble user preferences and settings. If you
        are logged in with a non-UA account, you can also update your email address 
        and password.  Lastly, you can delete your account completely.
    </span>
</x-srdd.callout>
@isset($return_status)
    @if(session('status') == 'password-updated')
    <x-srdd.success>
        Your password has been updated
    </x-srdd.success>
    @elseif(session('status') == 'profile-updated')
    <x-srdd.success>
        Your user account has been updated
    </x-srdd.success>
    @else
    <x-srdd.notice :title="__('Status')">
        {{ session('status') }}
    </x-srdd.notice>
    @endif
@endisset
<x-srdd.title-box :title="__('Preferences')" :state="0">
    <div class="m-2 p-4 bg-slate-200 rounded-sm">
        This area is for future Preference settings and updates &nbsp;
        <i class="bi bi-cone-striped"></i>
    </div>
</x-srdd.title-box>
@if(isset(Auth::user()->email) && Str::endsWith(Auth::user()->email, 'alaska.edu')) 
    <x-srdd.title-box :title="__('Update Account')" :state="0">
        <x-srdd.notice :title="__('UA Account')">
            <i class="bi bi-person-fill-slash"></i>&nbsp; Your <i>{{ Auth::user()->email }} </i> account
        was automatically created from your UA Google login along with a special random password.  Thus,
        they cannot be updated in this application.
        </x-srdd.notice>
    </x-srdd.title-box>
@else
    <x-srdd.title-box :title="__('Update Account')" :state="0">
        <div class="m-2 p-4 bg-slate-200 rounded-sm">
            @include('profile.partials.update-account')
        </div>
    </x-srdd.title-box>
    <x-srdd.title-box :title="__('Reset Password')" :state="1">
        <div class="m-2 p-4 bg-slate-200 rounded-sm">
            @include('profile.partials.reset-password')
        </div>
    </x-srdd.title-box>
@endif
<x-srdd.title-box :title="__('Delete Account')" :state="0">
    <x-srdd.warning>
        <p>
            Once your account is deleted, all of your session schedules and preferences will be permanently deleted. 
            Before deleting your account, please print or email any schedules that you wish to keep.
        </p>  
        <x-srdd.divider/>
        <x-danger-button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        >{{ __('Delete Account') }}
        </x-danger-button>
    </x-srdd.warning>
</x-srdd.title-box>
<div>&nbsp;</div>
<x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
    <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
        @csrf
        @method('delete')

        <h2 class="text-lg font-medium text-std">
            {{ __('Are you sure you want to delete your account?') }}
        </h2>

        <p class="mt-1 text-sm text-rose-700 dark:text-rose-300">
            {{ __('Once your account is deleted, you will be de-registered for any sessions you signed up for (in all SRDD years).') }}
        </p>

        <div class="mt-6 hidden">
            <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

            <x-text-input
                id="password"
                name="password"
                type="password"
                class="mt-1 block w-3/4"
                placeholder="{{ __('Password') }}"
            />

            <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
        </div>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ml-3">
                {{ __('Delete Account') }}
            </x-danger-button>
        </div>
    </form>
</x-modal>
@endsection


    

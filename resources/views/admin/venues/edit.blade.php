<?php 
    /*
     *  This is the edit/delete confirmation page for venues
     * 
     * @param $confirm, if set to 'NEED' then this is a delete request and verify it
 ``  */

    use App\Models\Venue;

 ?>

@extends('template.app')

@section('content')
<x-global.nav-admin/>
<div class="container">
@if (isset($confirm) && $confirm == 'NEED')
    <x-srdd.warning :title="__('Verify Deletion')">
        Are you sure that you want to delete Venue # {{ $venue->id }} "{{ $venue->location }}"?
        <form method="post" action="{{ route('venues.destroy', $venue) }}" class="p-6">
            @csrf
            @method('delete')
            <a class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
                href="{{ route('venues.index') }}">
                Cancel
            </a>
            &nbsp;
            <x-danger-button>
                {{ __('Confirm Delete') }}
            </x-danger-button>
        </div>
        </form>
    </x-srdd.warning>
@else 
    <x-srdd.title-box :title="__('Editing Venue #' . $venue->id)">
        <form method="POST" action="{{ route('venues.update', $venue) }}">
            @csrf
            @method ('patch')
            <div class="mx-2 grid grid-cols-6 auto-col-max-6 gap-0">
                <div class="col-span-1 table-header text-right pr-4">
                    <label for="location">Location</label>
                </div>
                <x-input-error :messages="$errors->get('location')" class="mt-2" />
                <div class="col-span-4 border border-indigo-800">
                    <input class="text-slate-900 w-4/5 "
                        type="input" name="location" 
                        value="{{$venue->location}}" 
                        maxlength="50"
                        width="50"/>
                </div>
                <div class="col-span-1 text-xs text-red-600 italic pl-2">
                    40 chars maximum
                </div>
                <div class="col-span-1 table-header text-right pr-4">
                    <label for="max_seats">Maximum Available Seats</label>
                </div>
                <x-input-error :messages="$errors->get('max_seats')" class="mt-2" />
                <div class="col-span-4 border border-indigo-800">
                    <input class="text-slate-900 w-4/5 "
                        type="input" name="max_seats"
                        value="{{$venue->max_seats}}" 
                        maxlength="10"
                        width="10"/>
                </div>
                <div class="col-span-1 text-xs text-red-600 italic pl-2">
                    -1 indicates unlimited seating
                </div>
                <div class="col-span-2">&nbsp;</div>
                <a class="inline-flex items-center mt-4 mx-2 px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
                    href="{{ route('venues.index') }}">           
                    {{__('ui.button.cancel') }}
                </a>
                <x-primary-button class="col-span-1 mt-4 mx-2">
                    {{ __('ui.button.update') }}
                </x-primary-button>
            </div>
        </form>
    </x-srdd.title-box>
@endif
</div>
@endsection
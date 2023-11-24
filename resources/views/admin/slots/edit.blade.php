<?php 
    /*
     *  This is the edit/delete confirmation page for slots
     * 
     * @param $confirm, if set to 'NEED' then this is a delete request and verify it
 ``  */

    use App\Models\Slot;

 ?>

@extends('template.app')

@section('content')
<x-admin.nav-admin/>
<div class="container">
@if (isset($confirm) && $confirm == 'NEED')
    <x-srdd.warning :title="__('Verify Deletion')">
        Are you sure that you want to delete Slot # {{ $slot->id }} "{{ $slot->title }}"?
        <form method="post" action="{{ route('slots.destroy', $slot) }}" class="p-6">
            @csrf
            @method('delete')
            <a class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
                href="{{ route('slots.index') }}">
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
    <x-global.title-box :title="__('Editing Slot #' . $slot->id)">
        <form method="POST" action="{{ route('slots.update', $slot) }}">
            @csrf
            @method ('patch')
            <div class="mx-2 grid grid-cols-6 auto-col-max-6 gap-0">
                <div class="col-span-1 table-header text-right pr-4">
                    <label for="title">Title</label>
                </div>
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                <div class="col-span-4 border border-indigo-800">
                    <input class="text-slate-900 w-4/5 "
                        type="input" name="title" 
                        value="{{$slot->title}}" 
                        maxlength="50"
                        width="50"/>
                </div>
                <div class="col-span-1 text-xs text-red-600 italic pl-2">
                    40 chars maximum
                </div>
                <div class="col-span-1 table-header text-right pr-4">
                    <label for="start_time">Starting Time</label>
                </div>
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                <div class="col-span-4 border border-indigo-800">
                    <input class="text-slate-900 w-4/5 "
                        type="time" name="start_time" id="start_time" 
                        value="{{$slot->start_time}}" 
                        maxlength="10"
                        width="10"/>
                </div>
                <div class="col-span-1 text-xs text-red-600 italic pl-2">
                    24hr, only between 0800 and 1800
                </div>
                <div class="col-span-1 table-header text-right pr-4">
                    <label for="end_time">Ending Time</label>
                </div>
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                <div class="col-span-4 border border-indigo-800">
                    <input class="text-slate-900 w-4/5 "
                        type="time" name="end_time" id="end_time"
                        value="{{$slot->end_time}}" 
                        maxlength="10"
                        width="10"/>
                </div>
                <div class="col-span-1 text-xs text-red-600 italic pl-2">
                    24hr, only between 0800 and 1800
                </div>
            </div>
            <div class="col-span-2">&nbsp;</div>
            <a class="inline-flex items-center mt-4 mx-2 px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
              href="{{ route('slots.index') }}">           
              {{__('ui.button.cancel') }}
            </a>
            <x-primary-button class="col-span-1 mt-4 mx-2">
                  {{ __('ui.button.update') }}
            </x-primary-button>
        </form>
    </x-global.title-box>
    <script>
        // wait until everything is loaded and then create the time widgets
        window.onload = function () {
            flatpickr("#start_time", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i:S",
                time_24hr: true,
                minTime: "08:00",
                maxTime: "17:00"
            });
            flatpickr("#end_time", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i:S",
                time_24hr: true,
                minTime: "09:00",
                maxTime: "18:00"
            });
        }
    </script>
@endif
</div>
@endsection
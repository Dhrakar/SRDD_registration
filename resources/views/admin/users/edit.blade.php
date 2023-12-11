<?php
    /**
     * Edits a user account for levels, etc.
     */

    use App\Models\User;

    // grab any associated events (if any)
    $events = $account->events;
    // grab anuy associated schedules
    $schedule = $account->schedules;
?>
@extends('template.app')

@section('content')
<x-srdd.nav-admin/>
<div class="container">
    <x-srdd.title-box :title="__('Editing User #' . $account->id)">
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
        <form method="POST" action="{{ route('users.update', $account) }}">
            @csrf
            @method ('patch')
            <div class="mx-2 grid grid-cols-6 auto-col-max-6 gap-0">
                <div class="col-span-1 table-header text-right pr-4">
                    <label for="name">Name</label>
                </div>
                <div class="col-span-4 border border-indigo-800">
                    <input class="text-slate-900 w-4/5 "
                      type="input" name="name" 
                      value="{{$account->name}}" 
                      maxlength="50"
                      width="50"/>
                </div>
                <div class="col-span-1 text-xs text-red-600 italic pl-2">
                  40 chars maximum
                </div>
                <div class="col-span-1 table-header text-right pr-4">
                    <label for="level">Auth Level</label>
                </div>
                <div class="col-span-4 border border-indigo-800">
                    <select name="level" class="ml-1 mr-8">
                        <?php
                            $levels = config('constants.auth_level');
                            foreach( $levels as $key => $val) {
                                if($val != 'root') { // do not allow setting another user to root
                                    echo "<option value='$key'>$val</option> \n";
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="col-span-1 text-xs text-red-600 italic pl-2">
                    Select the auth level for this user
                </div>
                <div class="col-span-1 table-header text-right pr-4">
                    <label for="is_locked">Acct Locked?</label>
                </div>
                <div class="col-span-4 border border-indigo-800">
                    <select name="is_locked" disabled class="ml-1 mr-8">
                        <option value="0" selected="selected">Unlocked</option>
                        <option value="0">Locked</option>
                    </select>
                </div>
                <div class="col-span-1 text-xs text-red-600 italic pl-2">
                    For future use
                </div>
            </div>
            <div class="col-span-2">&nbsp;</div>
                <a class="inline-flex items-center mt-4 mx-2 px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
                  href="{{ route('users.index') }}">           
                  {{__('ui.button.cancel') }}
                </a>
                <x-primary-button class="col-span-1 mt-4 mx-2">
                      {{ __('ui.button.update') }}
                </x-primary-button>
            </div>
        </form>
  </x-srdd.title-box>
</div>
@endsection
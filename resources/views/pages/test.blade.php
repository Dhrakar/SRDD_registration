@extends('template.app')
@section('content')
<div class="container h-view w-view">
    <x-srdd.nav-admin/>
    <button class="bg-emerald-400 border border-emerald-950 rounded-md m-8 px-2 text-std" data-tippy-content="Tooltip">
        Test of tooltip widget ...
    </button>
    <x-srdd.title-box :title="__('Title')">
        <span class="text-std">Test of the Title Box widget ...</span>
    </x-srdd.title-box>
    <x-srdd.callout>
        Test of the Callout widget ... 
    </x-srdd.callout>
    <x-srdd.notice>
        Test of the Notice widget ... 
    </x-srdd.notice>
    <x-srdd.success>
        Test of the Success widget ... 
    </x-srdd.success>
    <x-srdd.warning>
        Test of the Warning widget ... 
    </x-srdd.warning>
    <x-srdd.error>
        Test of the Error widget ... 
    </x-srdd.error>

    <!-- This button is used to open the dialog -->
    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion')"
    >
        Test Delete Button
    </x-danger-button>
    <x-modal name="confirm-deletion" focusable>
        <form method="get" action="/admin">
            <div class="mt-6 flex justify-end">
                <span class="pr-4 text-std">Test of the confirmation dialog.  No actual deletes will happen</span>
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3">
                    {{ __('Delete') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</div>
<div class="mt-8 p-2">&nbsp;</div>
@endsection
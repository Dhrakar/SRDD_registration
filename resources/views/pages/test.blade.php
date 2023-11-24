@extends('template.app')
@section('content')
<div class="container">
    <x-global.nav-admin/>
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
</div>
@endsection
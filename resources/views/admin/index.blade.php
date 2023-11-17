<?php 
    /*
     *  Administrative access landing page
     */

    use function Laravel\Folio\name;
    use function Laravel\Folio\{middleware};
 
    middleware(['auth', 'verified']);
 
    name('admin.index');

 ?>
@extends('template.app')

@section('content')
<x-admin.nav-admin/>
<div class="container">
    <div class="mx-10 mt-4 pb-5 w-auto border border-indigo-900 rounded-md">
        <div class="ml-10 px-2 -translate-y-3 w-min bg-white font-bold">
        Configuration&nbsp;&amp;&nbsp;Admin
        </div> 
    </div>
</div>
@endsection

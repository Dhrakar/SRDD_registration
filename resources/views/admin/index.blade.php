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
    <x-srdd.title-box :title="__('Admin/Configuration')">
        This is where you do stuff
    </x-srdd.title-box>
</div>
@endsection

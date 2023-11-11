<?php 
    /*
     *  Administrative access landing page
     */

    use function Laravel\Folio\name;
 
    name('admin.index');

 ?>
@extends('template.app')

@section('content')

    <div class="bg-green-200 ">
        Admin pages

        <a href="/admin/Track">Tracks</a>
    </div>

@endsection

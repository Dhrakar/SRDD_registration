<?php 
    /*
     *  Main SRDD reporting page
     */

 ?>
@extends('template.app')

@section('content')
<div class="container">
    <x-global.toolbar />
    <x-srdd.title-box :title="__('Reports')"/>
</div>
@endsection

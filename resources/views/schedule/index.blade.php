<?php 
    /*
     *  Main SRDD registration page
     */

 ?>
@extends('template.app')

@section('content')
<div class="container">
    <x-global.nav-header />
    <x-srdd.title-box :title="__('Registration')"/>
</div>
@endsection

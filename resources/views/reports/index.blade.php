<?php 
    /*
     *  Main SRDD reporting page
     */

 ?>
@extends('template.app')

@section('content')
<div class="container">
    <x-global.toolbar :icon="__('bi-file-earmark-ruled')"/>
    <x-srdd.title-box :title="__('Reports')"/>
</div>
@endsection

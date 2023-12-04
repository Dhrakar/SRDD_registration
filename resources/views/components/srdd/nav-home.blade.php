<?php
    /**
     * Navigation toolbar for the Home pages
     */
  
     // page variables for text color, etc
    $m_text_def  = "text-md text-slate-100 hover:text-teal-200";  // default menu text attributes 
    $m_text_sel  = "text-md font-semibold text-[#FFC000] ";  // test color when on that route
?>
<x-global.toolbar :target="__('/home')" :icon="__('bi-person-plus')">
@guest 
    <li class="mx-6">
        <a  class="text-md text-slate-100 hover:text-teal-200" 
            href="{{ route('register') }}">
            {{__('ui.link.register')}}
        </a>
    </li>
@endguest
@auth 
    <li class="mx-6 ">
        <a  class="text-md {{ (strpos(url()->current(), 'profile') !== false)?$m_text_sel:$m_text_def }}" 
            href="{{route('profile.edit')}}">
            <i class="bi bi-person-gear "></i>
            {{__('Profile')}}
        </a>
    </li>
    <li class="mx-6">
        <a  class="text-md {{ (strpos(url()->current(), 'schedule') !== false)?$m_text_sel:$m_text_def }}" 
            href="{{route('schedule')}}">
            <i class="bi bi-eyeglasses"></i>
            {{__('Review')}}
        </a>
    </li>
    <li class="mx-6">
        <a  class="text-md text-slate-100 hover:text-teal-200" href="#">
            <i class="bi bi-printer"></i>
            {{__('Print')}}
        </a>
    </li>
    <li class="mx-6">
        <a  class="text-md text-slate-100 hover:text-teal-200" href="#">
            <i class="bi bi-envelope-at"></i>
            {{__('Email')}}
        </a>
    </li>
@endauth
</x-global.toolbar>
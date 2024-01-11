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
            {{__('ui.menu.nav-home.profile')}}
        </a>
    </li>
    <li class="mx-6">
        <a  class="text-md {{ (url()->current() == route('schedule'))?$m_text_sel:$m_text_def }}" 
            href="{{route('schedule')}}">
            <i class="bi bi-eyeglasses"></i>
            {{__('ui.menu.nav-home.review')}}
        </a>
    </li>
    <li class="mx-6">
        <a  class="text-md {{ (strpos(url()->current(), 'print') !== false)?$m_text_sel:$m_text_def }}" 
            href="{{route('schedule.print')}}">
            <i class="bi bi-printer"></i>
            {{__('ui.menu.nav-home.print')}}
        </a>
    </li>
    <li class="mx-6">
        <a  class="text-md {{ (strpos(url()->current(), 'print') !== false)?$m_text_sel:$m_text_def }}" 
            href="{{route('schedule.email')}}">
            <i class="bi bi-envelope"></i>
            {{__('ui.menu.nav-home.email')}}
        </a>
    </li>
@endauth
</x-global.toolbar>
<?php
    /*
     * Navigation sub-tabs for the SRDD parts administration/configuration
     */

  // page variables for text color, etc
  $m_text_def  = "text-md text-slate-100 hover:text-teal-200";  // default menu text attributes 
  $m_text_sel  = "text-md font-semibold text-[#FFC000] ";  // test color when on that route
?>

<x-global.toolbar :target="__('/admin')" :icon="__('bi-gear')">
        <li class="mr-6">
            <a  class="{{ (strpos(url()->current(), 'tracks') !== false )?$m_text_sel:$m_text_def }}" 
                href="{{ route('tracks.index') }}">
                <i class="bi bi-pencil-square"></i>
                {{__('ui.menu.nav-admin.tracks')}}</a>
        </li>
        <li class="mr-6">
            <a  class="{{ (strpos(url()->current(), 'venues') !== false )?$m_text_sel:$m_text_def }}" 
                href="{{ route('venues.index') }}">
                <i class="bi bi-pencil-square"></i>
                {{__('ui.menu.nav-admin.venues')}}</a>
        </li>
        <li class="mr-6">
            <a  class="{{ (strpos(url()->current(), 'slots') !== false )?$m_text_sel:$m_text_def }}" 
                href="{{ route('slots.index') }}">
                <i class="bi bi-pencil-square"></i>
                {{__('ui.menu.nav-admin.slots')}}</a>
        </li>
        <li class="mr-6">
            <a  class="{{ (strpos(url()->current(), 'events') !== false )?$m_text_sel:$m_text_def }}" 
                href="{{ route('events.index') }}">
                <i class="bi bi-pencil-square"></i>
                {{__('ui.menu.nav-admin.events')}}</a>
        </li>
        <li class="mr-6">
            <a  class="{{ (strpos(url()->current(), 'sessions') !== false )?$m_text_sel:$m_text_def }}" 
                href="{{ route('sessions.index') }}">
                <i class="bi bi-pencil-square"></i>
                {{__('ui.menu.nav-admin.sessions')}}</a>
        </li>
        <li class="mr-6">
            <a  class="{{ (strpos(url()->current(), 'users') !== false )?$m_text_sel:$m_text_def }}" 
                href="#">
                <i class="bi bi-pencil-square"></i>
                {{__('ui.menu.nav-admin.users')}}</a>
        </li>
</x-global.toolbar>
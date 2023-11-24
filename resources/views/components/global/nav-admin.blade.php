{{--
  -- Sub-navigation bar for admin configurations 
--}}
<?php
    /*
     * Navigation sub-tabs for the SRDD parts administration/configuration
     */

  // page variables for text color, etc
  $m_text_def  = "text-md text-slate-100 hover:text-teal-200";  // default menu text attributes 
  $m_text_sel  = "text-md font-semibold text-[#FFC000] ";  // test color when on that route
?>

<x-global.nav-header>
        <li class="mr-6">
            <a  class="{{ (strpos(url()->current(), 'tracks') !== false )?$m_text_sel:$m_text_def }}" 
                href="{{ route('tracks.index') }}">{{__('Tracks')}}</a>
        </li>
        <li class="mr-6">
            <a  class="{{ (strpos(url()->current(), 'venues') !== false )?$m_text_sel:$m_text_def }}" 
                href="{{ route('venues.index') }}">{{__('Venues')}}</a>
        </li>
        <li class="mr-6">
            <a  class="{{ (strpos(url()->current(), 'slots') !== false )?$m_text_sel:$m_text_def }}" 
                href="{{ route('slots.index') }}">{{__('Slots')}}</a>
        </li>
        <li class="mr-6">
            <a  class="{{ (strpos(url()->current(), 'users') !== false )?$m_text_sel:$m_text_def }}" 
                href="#">{{__('Users')}}</a>
        </li>
        <li class="mr-6">
            <a  class="{{ (strpos(url()->current(), 'events') !== false )?$m_text_sel:$m_text_def }}" 
                href="#">{{__('Events')}}</a>
        </li>
        <li class="mr-6">
            <a  class="{{ (strpos(url()->current(), 'sessions') !== false )?$m_text_sel:$m_text_def }}" 
                href="#">{{__('Sessions')}}</a>
        </li>
</x-global.nav-header>
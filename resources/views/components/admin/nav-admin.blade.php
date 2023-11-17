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

<div class="bg-slate-700 text-sm font-bold py-1" style="list-style-type: none;">
    <ui class="flex">
        <li class="mx-2 text-indigo-300"><i class="bi bi-gear-wide-connected"></i></li>
        <li class="mr-6">
            <a  class="{{ (strpos(url()->current(), 'tracks') !== false )?$m_text_sel:$m_text_def }}" 
                href="{{ route('tracks.index') }}">{{__('Tracks')}}</a>
        </li>
        <li class="mr-6">
            <a  class="{{ (url()->current() == route('home'))?$m_text_sel:$m_text_def }}" 
                href="#">{{__('Venues')}}</a>
        </li>
        <li class="mr-6">
            <a  class="{{ (url()->current() == route('home'))?$m_text_sel:$m_text_def }}" 
                href="#">{{__('Slots')}}</a>
        </li>
        <li class="mr-6">
            <a  class="{{ (url()->current() == route('home'))?$m_text_sel:$m_text_def }}" 
                href="#">{{__('Users')}}</a>
        </li>
        <li class="mr-6">
            <a  class="{{ (url()->current() == route('home'))?$m_text_sel:$m_text_def }}" 
                href="#">{{__('Events')}}</a>
        </li>
        <li class="mr-6">
            <a  class="{{ (url()->current() == route('home'))?$m_text_sel:$m_text_def }}" 
                href="#">{{__('Sessions')}}</a>
        </li>
    </ul>
</div>
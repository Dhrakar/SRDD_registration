{{-- 
  -- Standard Banner that clones the UAF Banner 
  -- UAF Blue:   #236192
  -- UAF Yellow: #FFC000
  --}}

<div class="bg-[#236192] flex justify-between pt-1 pl-2">
    <div class="flex-none py-2">
        <a href="https://uaf.edu" title="UAF">
            <x-global.uaf-logo class="block h-16 w-auto fill-current text-white" />
            <!-- <img src="https://www.uaf.edu/_resources/images/uaflogoBlue.png" width="80px" height="43px"> -->
        </a>
    </div>
    <div class="inline-flex items-center mr-5 px-1 pt-1 text-md text-white">
        Staff Recognition &amp; Development Day {{ config('constants.srdd_year') }}
    </div>
</div>
<div class="w-screen h-1 bg-gradient-to-r from-cyan-200 to-[#FFC000]"></div>
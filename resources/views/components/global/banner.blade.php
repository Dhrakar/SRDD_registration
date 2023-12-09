 <?php
    /**
     *  Header file for getting a current-look UAF header block
     */
    use Illuminate\Support\Carbon;

    // reformat the SRDD date for the header
    $_date = Carbon::parse(env('SRD_DAY', now()))->toFormattedDateString();
?>
<div class="bg-[#236192] flex justify-between pt-1 pl-2">
    <div class="flex-none py-2">
        <a href="https://uaf.edu" title="UAF">
            <x-global.uaf-logo class="block h-16 w-auto fill-current text-white" />
            <!-- <img src="https://www.uaf.edu/_resources/images/uaflogoBlue.png" width="80px" height="43px"> -->
        </a>
    </div>
    <div class="inline-flex items-center mr-5 px-1 pt-1 text-md text-white">
        Staff Recognition &amp; Development Day: {{ $_date }}
    </div>
</div>
<div class="w-screen h-1 bg-gradient-to-r from-cyan-200 to-[#FFC000]"></div>
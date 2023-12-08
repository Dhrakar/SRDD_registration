<?php
    /**
     *  Global footer plus extra late loading dialogs, etc.
     */

?>

<div class="border-2 border-sky-600">
    <span class="text-xs text-std bg-slate-100 dark:bg-slate-900">Laravel Session Debug</span></br>
        {{ dd( session()->all() ) }}
</div>
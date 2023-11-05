<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    use HasFactory;

    /*
     * get the Track for this event
     */
    public function track(): BelongsTo {
        return $this->belongsTo(Track::class); 
    }

    /*
     * get the instructor/lead for this event
     * 
     */
    public function instructor(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    } 
}

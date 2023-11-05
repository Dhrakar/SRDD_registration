<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Session extends Model
{
    use HasFactory;

    /*
     * get the Event for this session
     */
    public function event(): BelongsTo {
        return $this->belongsTo(Event::class); 
    }

    /*
     * get the Venue for this session
     */
    public function venue(): BelongsTo {
        return $this->belongsTo(Venue::class); 
    }
    
    /*
     * get the Slot for this session
     */
    public function slot(): BelongsTo {
        return $this->belongsTo(Slot::class); 
    }
}

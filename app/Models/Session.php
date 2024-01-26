<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Session extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'event_id',
        'venue_id',
        'slot_id',
        'date_held',
        'start_time',
        'end_time',
        'is_closed',
        'url',
    ];

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

    /*
     * get any schedules for this session
     */
    public function schedules(): HasMany {
        return $this->hasMany(Schedule::class);
    }
}

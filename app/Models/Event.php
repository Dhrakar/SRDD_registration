<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'track_id',
        'user_id',
        'year',
        'title',
        'description',
        'needs_reg',
    ];

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

    /*
     * get any sessions for this event
     */
    public function sessions(): HasMany {
        return $this->hasMany(Session::class);
    }
}

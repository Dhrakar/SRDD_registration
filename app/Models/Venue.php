<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Venue extends Model
{
    /*
     * do not create timestamps
     */
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'location',
        'max_seats',
    ];

    /*
     * get any sessions for this venue
     */
    public function sessions(): HasMany {
        return $this->hasMany(Session::class);
    }
}

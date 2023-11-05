<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Track extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'color',
    ];

    /*
     * get any events that are assigned to this track
     */
    public function events(): HasMany {
        return $this->hasMany(Event::class);
    }
}

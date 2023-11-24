<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Slot extends Model
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
        'title',
        'start_time',
        'end_time',
    ];

    /*
     * get any sessions for this slot
     */
    public function sessions(): HasMany {
        return $this->hasMany(Session::class);
    }
}

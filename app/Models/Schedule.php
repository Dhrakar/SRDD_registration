<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'year',
        'user_id',
        'session_id',
    ];

    /*
     * get the User for this schedule
     */
    public function user(): BelongsTo {
        return $this->belongsTo(User::class); 
    }

    /*
     * get the Session for this schedule
     */
    public function session(): BelongsTo {
        return $this->belongsTo(Session::class); 
    }


}
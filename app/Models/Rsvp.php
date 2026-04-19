<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rsvp extends Model
{
    protected $fillable = [
        'wedding_id', 'guest_name', 'email', 'attending',
        'guests_count', 'message', 'notified',
    ];

    protected $casts = [
        'attending' => 'boolean',
        'notified'  => 'boolean',
    ];

    public function wedding()
    {
        return $this->belongsTo(Wedding::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rsvp extends Model
{
    protected $fillable = [
        'wedding_id',
        'wedding_guest_id',
        'guest_name',
        'email',
        'attending',
        'guests_count',
        'guest_names',
        'message',
        'notified',
    ];

    protected $casts = [
        'attending' => 'boolean',
        'notified' => 'boolean',
        'guest_names' => 'array',
    ];

    public function wedding()
    {
        return $this->belongsTo(Wedding::class);
    }
}

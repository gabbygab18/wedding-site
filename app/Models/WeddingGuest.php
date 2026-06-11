<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeddingGuest extends Model
{
    protected $fillable = ['wedding_id', 'name', 'seats_allotted'];

    public function wedding()
    {
        return $this->belongsTo(Wedding::class);
    }

    public function rsvp()
    {
        return $this->hasOne(Rsvp::class);
    }
}

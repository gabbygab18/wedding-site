<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wedding extends Model
{
    protected $fillable = [
        'bride_name',
        'groom_name',
        'wedding_date',
        'ceremony_time',
        'reception_time',
        'venue_name',
        'venue_address',
        'reception_venue',
        'love_story',
        'hashtag',
        'rsvp_enabled',
        'rsvp_deadline',
        'hero_video',
        'background_music',
        'map_embed_url',
    ];

    protected $casts = [
        'wedding_date' => 'date',
        'rsvp_enabled' => 'boolean',
        'rsvp_deadline' => 'date',
    ];

    public function photos()
    {
        return $this->hasMany(WeddingPhoto::class)->orderBy('sort_order');
    }

    public function entourage()
    {
        return $this->hasMany(EntourageMember::class)->orderBy('role');
    }

    public function rsvps()
    {
        return $this->hasMany(Rsvp::class);
    }

    public function guests()
    {
        return $this->hasMany(WeddingGuest::class);
    }
}

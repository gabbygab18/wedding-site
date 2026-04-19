<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeddingPhoto extends Model
{
    protected $fillable = ['wedding_id', 'path', 'sort_order'];

    public function wedding()
    {
        return $this->belongsTo(Wedding::class);
    }
}

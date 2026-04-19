<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntourageMember extends Model
{
    protected $fillable = ['wedding_id', 'name', 'role', 'side'];

    public function wedding()
    {
        return $this->belongsTo(Wedding::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VitalSign extends Model
{
    protected $guarded = ['id'];

    public function encounter()
    {
        return $this->belongsTo(Encounter::class);
    }
}

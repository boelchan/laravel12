<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Encounter extends Model
{
    protected $guarded = ['id'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function vitalSign()
    {
        return $this->hasOne(VitalSign::class);
    }

    public function anthropometry()
    {
        return $this->hasOne(Anthropometry::class);
    }

    public function hasils()
    {
        return $this->hasMany(Hasil::class);
    }

    public function reseps()
    {
        return $this->hasMany(Resep::class);
    }
}

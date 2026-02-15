<?php

namespace App\Models;

use Aliziodev\IndonesiaRegions\Models\IndonesiaRegion;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $guarded = ['id'];

    public function province()
    {
        return $this->belongsTo(IndonesiaRegion::class, 'province_code', 'code');
    }

    public function regency()
    {
        return $this->belongsTo(IndonesiaRegion::class, 'regency_code', 'code');
    }

    public function district()
    {
        return $this->belongsTo(IndonesiaRegion::class, 'district_code', 'code');
    }

    public function village()
    {
        return $this->belongsTo(IndonesiaRegion::class, 'village_code', 'code');
    }
}

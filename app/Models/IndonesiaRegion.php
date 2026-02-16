<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndonesiaRegion extends Model
{
    protected $table = 'indonesia_regions';
    protected $primaryKey = 'code';
    protected $keyType = 'integer';
    public $incrementing = false;
    public $timestamps = false;
}

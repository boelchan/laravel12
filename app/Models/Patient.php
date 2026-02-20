<?php

namespace App\Models;

use App\Enums\GenderEnum;
use App\Enums\ReligionEnum;
use App\Enums\EducationEnum;
use App\Enums\MaritalStatusEnum;
use App\Enums\NationalityEnum;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'gender' => GenderEnum::class,
        'religion' => ReligionEnum::class,
        'education' => EducationEnum::class,
        'marital_status' => MaritalStatusEnum::class,
        'nationality' => NationalityEnum::class,
        'birth_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function getUmurSekarangAttribute()
    {
        $birth_date = $this->birth_date;
        $today = now();
        $age = $today->diff($birth_date)->y;
        $month = $today->diff($birth_date)->m;
        $day = $today->diff($birth_date)->d;
        return $age . ' th ' . $month . ' bln ' . $day . ' hr';
    }

    public static function generateMedicalRecordNumber()
    {
        $latest = static::orderBy('id', 'desc')->first();
        if (!$latest) {
            return 'RM-000001';
        }
        $number = (int) str_replace('RM-', '', $latest->medical_record_number);
        return 'RM-' . str_pad($number + 1, 6, '0', STR_PAD_LEFT);
    }

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

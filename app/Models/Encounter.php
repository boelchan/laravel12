<?php

namespace App\Models;

use App\Enums\StatusEncounterEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Encounter extends Model
{
    protected $guarded = ['id'];

    public static function createEncounter(array $data)
    {
        return DB::transaction(function () use ($data) {

            $antrian = self::antrianTerakhir($data['visit_date']);

            return parent::create([
                'uuid' => Str::uuid(),
                'patient_id' => $data['patient_id'],
                'visit_date' => $data['visit_date'],
                'no_antrian' => $antrian + 1,
                'status' => StatusEncounterEnum::REGISTERED,
                'created_by' => Auth::id(),
            ]);
        });
    }

    public static function antrianTerakhir($visit_date)
    {
        return DB::transaction(function () use ($visit_date) {

            return self::where('visit_date', $visit_date)
                ->lockForUpdate()
                ->count();
        });
    }

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

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function getStatusBadgeAttribute()
    {
        return StatusEncounterEnum::from($this->status)->badge();
    }
}

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

            $countEncounter = self::where('visit_date', $data['visit_date'])
                ->lockForUpdate()
                ->count();

            return parent::create([
                'uuid' => Str::uuid(),
                'patient_id' => $data['patient_id'],
                'visit_date' => $data['visit_date'],
                'no_antrian' => $countEncounter + 1,
                'status' => StatusEncounterEnum::REGISTERED,
                'created_by' => Auth::id(),
            ]);
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

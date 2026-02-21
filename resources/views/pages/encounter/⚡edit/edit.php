<?php

use App\Models\Encounter;
use App\Models\VitalSign;
use App\Models\Anthropometry;
use App\Models\Hasil;
use App\Models\Resep;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

new class extends Component
{
    use Interactions;
    
    public Encounter $encounter;
    
    public $systolic, $diastolic,  $body_temperature;
    public $body_weight, $body_height;
    public $hasil_text, $resep_text;
    
    public $sig_hasil_dokter, $sig_hasil_pasien;
    public $sig_resep_dokter, $sig_resep_apoteker;

    public function mount(Encounter $encounter)
    {
        $this->encounter = $encounter->load('vitalSign', 'anthropometry');
        
        // Load TTV
        if ($this->encounter->vitalSign) {
            $this->systolic = $this->encounter->vitalSign->systolic;
            $this->diastolic = $this->encounter->vitalSign->diastolic;
            $this->body_temperature = $this->encounter->vitalSign->body_temperature;
        }

        // Load Antropometri
        if ($this->encounter->anthropometry) {
            $this->body_weight = $this->encounter->anthropometry->body_weight;
            $this->body_height = $this->encounter->anthropometry->body_height;
        }
        
        // Load Hasil & Resep (Tipe Text)
        // We look for 'text' or NULL (as fallback for old data)
        $hasilTable = Hasil::where('encounter_id', $this->encounter->id)
            ->where(function($q) {
                $q->where('tipe', 'text')->orWhereNull('tipe');
            })->first();
        $this->hasil_text = $hasilTable->hasil ?? '';
        
        $resepTable = Resep::where('encounter_id', $this->encounter->id)
            ->where(function($q) {
                $q->where('tipe', 'text')->orWhereNull('tipe');
            })->first();
        $this->resep_text = $resepTable->resep ?? '';

        // Load Signatures (Tipe Draw)
        $hasilDraw = Hasil::where('encounter_id', $this->encounter->id)->where('tipe', 'draw')->first();
        $this->sig_hasil_dokter = $hasilDraw->signature_1 ?? '';
        $this->sig_hasil_pasien = $hasilDraw->signature_2 ?? '';

        $resepDraw = Resep::where('encounter_id', $this->encounter->id)->where('tipe', 'draw')->first();
        $this->sig_resep_dokter = $resepDraw->signature_1 ?? '';
        $this->sig_resep_apoteker = $resepDraw->signature_2 ?? '';
    }

    public function setSignatures($data)
    {
        $this->sig_hasil_dokter = $data['sig_hasil_dokter'];
        $this->sig_hasil_pasien = $data['sig_hasil_pasien'];
        $this->sig_resep_dokter = $data['sig_resep_dokter'];
        $this->sig_resep_apoteker = $data['sig_resep_apoteker'];
        
        $this->update();
    }

    public function update()
    {
        // 1. Save TTV
        VitalSign::updateOrCreate(
            ['encounter_id' => $this->encounter->id],
            [
                'systolic' => is_numeric($this->systolic) ? (int)$this->systolic : null,
                'diastolic' => is_numeric($this->diastolic) ? (int)$this->diastolic : null,
                'body_temperature' => is_numeric($this->body_temperature) ? (int)$this->body_temperature : null,
                'created_by' => Auth::id(),
            ]
        );

        // 2. Save Antropometri
        Anthropometry::updateOrCreate(
            ['encounter_id' => $this->encounter->id],
            [
                'body_weight' => is_numeric($this->body_weight) ? (int)$this->body_weight : null,
                'body_height' => is_numeric($this->body_height) ? (int)$this->body_height : null,
                'created_by' => Auth::id(),
            ]
        );

        // 3. Save Hasil (Tipe Text)
        Hasil::updateOrCreate(
            ['encounter_id' => $this->encounter->id, 'tipe' => 'text'],
            [
                'hasil' => $this->hasil_text,
                'created_by' => Auth::id(),
            ]
        );

        // 4. Save Hasil (Tipe Draw)
        Hasil::updateOrCreate(
            ['encounter_id' => $this->encounter->id, 'tipe' => 'draw'],
            [
                'signature_1' => $this->sig_hasil_dokter,
                'signature_2' => $this->sig_hasil_pasien,
                'created_by' => Auth::id(),
            ]
        );

        // 5. Save Resep (Tipe Text)
        Resep::updateOrCreate(
            ['encounter_id' => $this->encounter->id, 'tipe' => 'text'],
            [
                'resep' => $this->resep_text,
                'created_by' => Auth::id(),
            ]
        );

        // 6. Save Resep (Tipe Draw)
        Resep::updateOrCreate(
            ['encounter_id' => $this->encounter->id, 'tipe' => 'draw'],
            [
                'signature_1' => $this->sig_resep_dokter,
                'signature_2' => $this->sig_resep_apoteker,
                'created_by' => Auth::id(),
            ]
        );

        $this->toast()->success('Data pemeriksaan berhasil diperbarui.')->send();
        
        return to_route('encounter.index');
    }
};
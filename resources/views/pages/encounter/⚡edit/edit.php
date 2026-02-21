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
    
    public $td, $hr, $rr, $temp;
    public $bb, $tb, $lp;
    public $hasil_text, $resep_text;
    
    public $sig_hasil_dokter, $sig_hasil_pasien;
    public $sig_resep_dokter, $sig_resep_apoteker;

    public function mount(Encounter $encounter)
    {
        $this->encounter = $encounter->load('vitalSign', 'anthropometry');
        
        // Load TTV
        if ($this->encounter->vitalSign) {
            $this->td = ($this->encounter->vitalSign->systolic ?? '') . '/' . ($this->encounter->vitalSign->diastolic ?? '');
            $this->hr = $this->encounter->vitalSign->heart_rate;
            $this->rr = $this->encounter->vitalSign->respiratory_rate;
            $this->temp = $this->encounter->vitalSign->body_temperature;
        }

        // Load Antropometri
        if ($this->encounter->anthropometry) {
            $this->bb = $this->encounter->anthropometry->body_weight;
            $this->tb = $this->encounter->anthropometry->body_height;
        }
        
        // Load Hasil & Resep (Tipe Text)
        $hasilTable = Hasil::where('encounter_id', $this->encounter->id)->where('tipe', 'text')->first();
        $this->hasil_text = $hasilTable->hasil ?? '';
        
        $resepTable = Resep::where('encounter_id', $this->encounter->id)->where('tipe', 'text')->first();
        $this->resep_text = $resepTable->resep ?? '';
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
        // Parse TD (Tensi)
        $systolic = null;
        $diastolic = null;
        if ($this->td && strpos($this->td, '/') !== false) {
            $parts = explode('/', $this->td);
            $systolic = trim($parts[0]);
            $diastolic = trim($parts[1] ?? '');
        }

        // 1. Save TTV
        VitalSign::updateOrCreate(
            ['encounter_id' => $this->encounter->id],
            [
                'systolic' => is_numeric($systolic) ? (int)$systolic : null,
                'diastolic' => is_numeric($diastolic) ? (int)$diastolic : null,
                'heart_rate' => is_numeric($this->hr) ? (int)$this->hr : null,
                'respiratory_rate' => is_numeric($this->rr) ? (int)$this->rr : null,
                'body_temperature' => is_numeric($this->temp) ? (int)$this->temp : null,
                'created_by' => Auth::id(),
            ]
        );

        // 2. Save Antropometri
        Anthropometry::updateOrCreate(
            ['encounter_id' => $this->encounter->id],
            [
                'body_weight' => is_numeric($this->bb) ? (int)$this->bb : null,
                'body_height' => is_numeric($this->tb) ? (int)$this->tb : null,
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
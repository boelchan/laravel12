<?php

use App\Livewire\Traits\WithTableX;
use App\Models\Encounter;
use App\Models\Patient;
use App\Models\VitalSign;
use App\Models\Anthropometry;
use App\Models\IndonesiaRegion;
use Livewire\Component;
use Livewire\Attributes\Computed;
use TallStackUi\Traits\Interactions;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

new class extends Component
{
    use WithTableX, Interactions;

    public $sortFieldDefault = 'no_antrian';
    public $sortDirectionDefault = 'desc';

    public $search_full_name = '';
    public $search_medical_record_number = '';
    public $search_visit_date = '';
    public $search_status = '';

    // Create Encounter form
    public $modalEncounter = false;
    public $patient_id;
    public $visit_date;
    public $searchPatientName = '';
    public $searchPatientMRN = '';
    public $searchPatientVillage = '';
    public $selectedPatientName = '';

    // Vitals form
    public $modalObservation = false;
    public $encounter_id;
    public $systolic, $diastolic, $heart_rate, $respiratory_rate, $body_temperature;
    public $body_height, $body_weight;

    public function mount()
    {
        $this->search_visit_date = now()->format('Y-m-d');
    }

    public function updatedVisitDate($value)
    {
        $this->dispatch('load-jumlah-pendaftar', $value);
    }

    #[Computed]
    public function dataTable()
    {
        return Encounter::with('patient', 'vitalSign', 'anthropometry')
            ->when($this->search_full_name, function ($q) {
                $q->whereHas('patient', function ($q2) {
                    $q2->where('full_name', 'like', '%' . $this->search_full_name . '%');
                });
            })
            ->when($this->search_medical_record_number, function ($q) {
                $q->whereHas('patient', function ($q2) {
                    $q2->where('medical_record_number', $this->search_medical_record_number);
                });
            })
            ->when($this->search_status, fn($q) => $q->where('status', $this->search_status))
            ->where('visit_date', $this->search_visit_date ?? now()->format('Y-m-d'))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage)
            ->onEachSide(1);
    }

    public function delete($id)
    {
        $encounter = Encounter::findOrFail($id);
        $encounter->delete();
        $this->toast()->success('Kunjungan berhasil dihapus')->send();
    }

    public function batalkan($id)
    {
        $encounter = Encounter::findOrFail($id);
        $encounter->update(['status' => 'cancelled']);
        $this->toast()->success('Kunjungan berhasil dibatalkan')->send();
    }

    #[Computed]
    public function stats()
    {
        $date = $this->search_visit_date ?: date('Y-m-d');
        $data = Encounter::where('visit_date', $date)->get();

        return [
            'total' => $data->count(),
            'arrived' => $data->whereIn('status', ['arrived', 'inprogress', 'finished'])->count(),
            'finished' => $data->where('status', 'finished')->count(),
            'cancelled' => $data->where('status', 'cancelled')->count(),
        ];
    }

    #[Computed]
    public function patientList()
    {
        if (strlen($this->searchPatientName) < 1 && strlen($this->searchPatientMRN) < 1 && !$this->searchPatientVillage) return collect();

        return Patient::query()
            ->with('village')
            ->when($this->searchPatientName, fn($q) => $q->where('full_name', 'like', '%' . $this->searchPatientName . '%'))
            ->when($this->searchPatientMRN, fn($q) => $q->where('medical_record_number', 'like', '%' . $this->searchPatientMRN . '%'))
            ->when($this->searchPatientVillage, fn($q) => $q->whereHas('village', fn($q2) => $q2->where('name', 'like',  $this->searchPatientVillage . '%')))
            ->orderBy('full_name')
            ->limit(10)
            ->get();
    }

    public function selectPatient($id)
    {
        $patient = Patient::find($id);
        if ($patient) {
            $this->patient_id = $patient->id;
            $this->selectedPatientName = $patient->full_name . ' (' . $patient->medical_record_number . ')';
            $this->reset(['searchPatientName', 'searchPatientMRN', 'searchPatientVillage']);
        }
    }

    public function openModalEncounter()
    {
        $this->reset(['patient_id', 'visit_date', 'searchPatientName', 'searchPatientMRN', 'searchPatientVillage', 'selectedPatientName']);
        $this->modalEncounter = true;
    }

    #[Computed]
    public function patientHistory()
    {
        if (!$this->patient_id) return collect();
        return Encounter::where('patient_id', $this->patient_id)
            ->with('vitalSign')
            ->latest('visit_date')
            ->limit(10)
            ->get();
    }

    #[Computed]
    public function isAlreadyRegistered()
    {
        if (!$this->patient_id || !$this->visit_date) return false;
        return Encounter::where('patient_id', $this->patient_id)
            ->where('visit_date', $this->visit_date)
            ->where('status', '!=', 'cancelled')
            ->exists();
    }

    public function saveEncounter()
    {
        $this->validate([
            'patient_id' => 'required|exists:patients,id',
            'visit_date' => 'required|date',
        ]);

        Encounter::createEncounter([
            'patient_id' => $this->patient_id,
            'visit_date' => $this->visit_date,
        ]);

        $this->modalEncounter = false;
        $this->search_visit_date = $this->visit_date;

        $this->toast()->success('Kunjungan berhasil ditambahkan')->send();
    }

    public function setArrived($id)
    {
        $encounter = Encounter::findOrFail($id);
        $encounter->update([
            'status' => 'arrived',
            'arrived_at' => now(),
        ]);

        $this->modalEncounter = false;
        $this->toast()->success('Status kunjungan diperbarui menjadi Datang')->send();
    }

    public function setInprogress($id)
    {
        Encounter::where('status', 'inprogress')->whereNotIn('status', ['finished', 'canceled'])
            ->update(['status' => 'arrived']);

        $encounter = Encounter::findOrFail($id);
        $encounter->update([
            'status' => 'inprogress',
            'inprogress_at' => now(),
        ]);
    }

    public function openModalObservation($id)
    {
        $encounter = Encounter::findOrFail($id);

        $this->encounter_id = $id;
        $this->reset(['systolic', 'diastolic', 'body_temperature', 'body_height', 'body_weight']);

        // Load existing vitals if any
        $vitals = VitalSign::where('encounter_id', $id)->first();
        if ($vitals) {
            $this->systolic = $vitals->systolic;
            $this->diastolic = $vitals->diastolic;
            $this->body_temperature = $vitals->body_temperature;
        }

        $anthropometry = Anthropometry::where('encounter_id', $id)->first();
        if ($anthropometry) {
            $this->body_height = $anthropometry->body_height;
            $this->body_weight = $anthropometry->body_weight;
        }

        $this->modalObservation = true;
    }

    public function saveObservation()
    {
        $this->validate([
            'systolic' => 'nullable|integer',
            'diastolic' => 'nullable|integer',
            'body_temperature' => 'nullable|numeric',
            'body_height' => 'nullable|integer',
            'body_weight' => 'nullable|integer',
        ]);

        VitalSign::updateOrCreate(
            ['encounter_id' => $this->encounter_id],
            [
                'systolic' => $this->systolic,
                'diastolic' => $this->diastolic,
                'body_temperature' => $this->body_temperature,
                'created_by' => Auth::id(),
            ]
        );

        Anthropometry::updateOrCreate(
            ['encounter_id' => $this->encounter_id],
            [
                'body_height' => $this->body_height,
                'body_weight' => $this->body_weight,
                'created_by' => Auth::id(),
            ]
        );

        $this->modalObservation = false;
        $this->toast()->success('Observasi berhasil disimpan')->send();
    }
};

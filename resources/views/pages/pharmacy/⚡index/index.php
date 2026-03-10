<?php

use App\Livewire\Traits\WithTableX;
use App\Models\Encounter;
use App\Models\Resep;
use Livewire\Component;
use Livewire\Attributes\Computed;
use TallStackUi\Traits\Interactions;
use Illuminate\Support\Facades\Auth;

new class extends Component
{
    use WithTableX, Interactions;

    public $sortFieldDefault = 'finished_at';
    public $sortDirectionDefault = 'desc';

    public $search_full_name = '';
    public $search_medical_record_number = '';
    public $search_visit_date = '';
    public $search_status_obat = ''; // 'taken', 'not_taken'

    public $modalResep = false;
    public $selectedEncounterId;
    public $catatan_farmasi;

    public function mount()
    {
        $this->search_visit_date = date('Y-m-d');
        $this->mountWithTableX();
    }

    #[Computed]
    public function dataTable()
    {
        return Encounter::with('patient', 'reseps')
            ->whereNotNull('finished_at')
            ->whereHas('reseps')
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
            ->when($this->search_status_obat, function ($q) {
                if ($this->search_status_obat === 'taken') {
                    $q->whereNotNull('obat_diambil_at');
                } else {
                    $q->whereNull('obat_diambil_at');
                }
            })
            ->where('visit_date', $this->search_visit_date ?? now()->format('Y-m-d'))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function openModalResep($id)
    {
        $this->selectedEncounterId = $id;
        $encounter = Encounter::findOrFail($id);
        $this->catatan_farmasi = $encounter->catatan_farmasi;
        $this->modalResep = true;
    }

    #[Computed]
    public function selectedEncounter()
    {
        if (!$this->selectedEncounterId) return null;
        return Encounter::with('patient', 'reseps')->find($this->selectedEncounterId);
    }

    public function markAsTaken()
    {
        $encounter = Encounter::findOrFail($this->selectedEncounterId);
        $encounter->update([
            'obat_diambil_at' => now(),
            'catatan_farmasi' => $this->catatan_farmasi,
        ]);

        $this->modalResep = false;
        $this->toast()->success('Obat telah ditandai sebagai diambil')->send();
    }

    public function unmarkAsTaken($id)
    {
        $encounter = Encounter::findOrFail($id);
        $encounter->update([
            'obat_diambil_at' => null,
        ]);

        $this->toast()->success('Status pengambilan obat dibatalkan')->send();
    }
};
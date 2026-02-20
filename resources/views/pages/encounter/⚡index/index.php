<?php

use App\Livewire\Traits\WithTableX;
use App\Models\Encounter;
use Livewire\Component;
use Livewire\Attributes\Computed;
use TallStackUi\Traits\Interactions;

new class extends Component
{
    use WithTableX, Interactions;

    public $sortFieldDefault = 'visit_date';
    public $sortDirectionDefault = 'desc';

    public $search_full_name = '';
    public $search_medical_record_number = '';
    public $search_visit_date = '';
    public $search_status = '';

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
            ->when($this->search_visit_date, fn($q) => $q->where('visit_date', $this->search_visit_date))
            ->when($this->search_status, fn($q) => $q->where('status', $this->search_status))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage)
            ->onEachSide(1);
    }

    public function delete($id)
    {
        $patient = Encounter::findOrFail($id);
        $patient->delete();
        $this->toast()->success('Kunjungan berhasil dihapus')->send();
    }
};

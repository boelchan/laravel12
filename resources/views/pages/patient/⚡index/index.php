<?php

use App\Livewire\Traits\WithTableX;
use App\Models\Patient;
use Livewire\Component;
use Livewire\Attributes\Computed;
use TallStackUi\Traits\Interactions;

new class extends Component
{
    use WithTableX, Interactions;

    public $sortFieldDefault = 'medical_record_number';
    public $sortDirectionDefault = 'desc';

    public $search_full_name = '';
    public $search_medical_record_number = '';
    public $search_nik = '';
    public $search_phone = '';

    #[Computed]
    public function dataTable()
    {
        return Patient::query()
            ->when($this->search_full_name, fn($q) => $q->where('full_name', 'like', '%' . $this->search_full_name . '%'))
            ->when($this->search_medical_record_number, fn($q) => $q->where('medical_record_number', 'like', '%' . $this->search_medical_record_number . '%'))
            ->when($this->search_nik, fn($q) => $q->where('nik', 'like', '%' . $this->search_nik . '%'))
            ->when($this->search_phone, fn($q) => $q->where('phone', 'like', '%' . $this->search_phone . '%')
                ->orWhere('mobile_phone', 'like', '%' . $this->search_phone . '%'))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage)
            ->onEachSide(1);
    }

    public function delete($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();
        $this->toast()->success('Pasien berhasil dihapus')->send();
    }
};

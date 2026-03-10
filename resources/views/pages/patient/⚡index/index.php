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
    public $search_village = '';
    public $search_status = '';

    #[Computed]
    public function dataTable()
    {
        return Patient::query()
            ->with('village')
            ->when($this->search_full_name, fn($q) => $q->where('full_name', 'like', '%' . $this->search_full_name . '%'))
            ->when($this->search_medical_record_number, fn($q) => $q->where('medical_record_number', 'like', '%' . $this->search_medical_record_number . '%'))
            ->when($this->search_village, function ($q) {
                $q->whereHas('village', function ($q2) {
                    $q2->where('name', 'like', $this->search_village . '%');
                });
            })
            ->when($this->search_status, function ($q) {
                if ($this->search_status == 'aktif') {
                    $q->where('is_active', true);
                } else {
                    $q->where('is_active', false);
                }
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function delete($id)
    {
        $patient = Patient::findOrFail($id);
        if ($patient->encounter()->count() > 0) {
            $patient->update([
                'is_active' => false,
            ]);
            $this->toast()->success('Pasien berhasil dinonaktifkan')->send();
            return;
        }

        $patient->delete();
        $this->toast()->success('Pasien berhasil dihapus')->send();
    }

    public function aktifkanPasien($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->update([
            'is_active' => true,
        ]);

        $this->toast()->success('Pasien berhasil diaktifkan')->send();
    }
};

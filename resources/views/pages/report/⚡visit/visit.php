<?php

use App\Livewire\Traits\WithTableX;
use App\Models\Encounter;
use App\Enums\StatusEncounterEnum;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\DB;
use Spatie\SimpleExcel\SimpleExcelWriter;

new class extends Component
{
    use WithTableX;

    public $sortFieldDefault = 'visit_date';
    public $sortDirectionDefault = 'asc';
    
    public $search_month;
    public $search_status;
    
    public function mount()
    {
        $this->perPage = 50;
        $this->search_month = date('Y-m');
    }

    #[Computed]
    public function dataTable()
    {
        return Encounter::query()
            ->select('visit_date', DB::raw('count(*) as total'))
            ->when($this->search_month, function ($q) {
                $q->where('visit_date', 'like', $this->search_month . '%');
            })
            ->when($this->search_status, function ($q) {
                $q->where('status', $this->search_status);
            })
            ->groupBy('visit_date')
            ->orderBy($this->sortField === 'id' ? 'visit_date' : $this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function export()
    {
        $data = Encounter::query()
            ->select('visit_date', DB::raw('count(*) as total'))
            ->when($this->search_month, function ($q) {
                $q->where('visit_date', 'like', $this->search_month . '%');
            })
            ->when($this->search_status, function ($q) {
                $q->where('status', $this->search_status);
            })
            ->groupBy('visit_date')
            ->orderBy('visit_date', 'asc')
            ->get()
            ->map(fn($item) => [
                'Tanggal' => $item->visit_date,
                'Jumlah Kunjungan' => $item->total,
            ]);

        $fileName = 'rekap-kunjungan-' . ($this->search_month ?: 'semua') . '.xlsx';
        
        $writer = SimpleExcelWriter::streamDownload($fileName);
        
        if ($data->isEmpty()) {
            $writer->addRow(['Data tidak ditemukan', '']);
        } else {
            $writer->addRows($data->toArray());
        }

        return $writer->toBrowser();
    }
};

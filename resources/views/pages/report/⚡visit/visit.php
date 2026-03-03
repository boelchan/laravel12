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
    
    public function mount()
    {
        $this->search_month = date('Y-m');
    }

    private function baseQuery()
    {
        return Encounter::query()
            ->select(
                'visit_date',
                DB::raw('count(*) as total'),
                DB::raw("SUM(CASE WHEN status = 'registered' THEN 1 ELSE 0 END) as belum_datang"),
                DB::raw("SUM(CASE WHEN status = 'arrived' THEN 1 ELSE 0 END) as datang"),
                DB::raw("SUM(CASE WHEN status = 'inprogress' THEN 1 ELSE 0 END) as in_progress"),
                DB::raw("SUM(CASE WHEN status = 'finished' THEN 1 ELSE 0 END) as selesai"),
                DB::raw("SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) as batal"),
            )
            ->when($this->search_month, function ($q) {
                $q->where('visit_date', 'like', $this->search_month . '%');
            })
            ->groupBy('visit_date');
    }

    #[Computed]
    public function dataTable()
    {
        return $this->baseQuery()
            ->orderBy($this->sortField === 'id' ? 'visit_date' : $this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    }

    #[Computed]
    public function grandTotals()
    {
        return Encounter::query()
            ->select(
                DB::raw('count(*) as total'),
                DB::raw("SUM(CASE WHEN status = 'registered' THEN 1 ELSE 0 END) as belum_datang"),
                DB::raw("SUM(CASE WHEN status = 'arrived' THEN 1 ELSE 0 END) as datang"),
                DB::raw("SUM(CASE WHEN status = 'inprogress' THEN 1 ELSE 0 END) as in_progress"),
                DB::raw("SUM(CASE WHEN status = 'finished' THEN 1 ELSE 0 END) as selesai"),
                DB::raw("SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) as batal"),
            )
            ->when($this->search_month, function ($q) {
                $q->where('visit_date', 'like', $this->search_month . '%');
            })
            ->first();
    }

    public function export()
    {
        $data = $this->baseQuery()
            ->orderBy('visit_date', 'asc')
            ->get()
            ->map(fn($item) => [
                'Tanggal' => $item->visit_date,
                'Total' => $item->total,
                'Belum Datang' => $item->belum_datang,
                'Datang' => $item->datang,
                'In Progress' => $item->in_progress,
                'Selesai' => $item->selesai,
                'Batal' => $item->batal,
            ]);

        $fileName = 'rekap-kunjungan-' . ($this->search_month ?: 'semua') . '.xlsx';
        
        return response()->streamDownload(function() use ($data) {
            $writer = SimpleExcelWriter::create('php://output', 'xlsx');
            
            if ($data->isEmpty()) {
                $writer->addRow(['Data tidak ditemukan', '', '', '', '', '', '']);
            } else {
                $writer->addRows($data->toArray());
            }

            $writer->close();
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
};

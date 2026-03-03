<?php

use App\Livewire\Traits\WithTableX;
use App\Models\Patient;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\DB;
use Spatie\SimpleExcel\SimpleExcelWriter;

new class extends Component
{
    use WithTableX;

    public $sortFieldDefault = 'date';
    public $sortDirectionDefault = 'asc';
    
    public $search_month;
    
    public function mount()
    {
        $this->search_month = date('Y-m');
    }

    private function baseQuery()
    {
        return Patient::query()
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as total'),
                DB::raw("SUM(CASE WHEN gender = 'male' THEN 1 ELSE 0 END) as laki_laki"),
                DB::raw("SUM(CASE WHEN gender = 'female' THEN 1 ELSE 0 END) as perempuan"),
            )
            ->when($this->search_month, function ($q) {
                $q->where('created_at', 'like', $this->search_month . '%');
            })
            ->groupBy('date');
    }

    #[Computed]
    public function dataTable()
    {
        return $this->baseQuery()
            ->orderBy($this->sortField === 'id' ? 'date' : $this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    }

    #[Computed]
    public function grandTotals()
    {
        return Patient::query()
            ->select(
                DB::raw('count(*) as total'),
                DB::raw("SUM(CASE WHEN gender = 'male' THEN 1 ELSE 0 END) as laki_laki"),
                DB::raw("SUM(CASE WHEN gender = 'female' THEN 1 ELSE 0 END) as perempuan"),
            )
            ->when($this->search_month, function ($q) {
                $q->where('created_at', 'like', $this->search_month . '%');
            })
            ->first();
    }

    public function export()
    {
        $data = $this->baseQuery()
            ->orderBy('date', 'asc')
            ->get()
            ->map(fn($item) => [
                'Tanggal' => $item->date,
                'Total' => $item->total,
                'Laki-laki' => $item->laki_laki,
                'Perempuan' => $item->perempuan,
            ]);

        $fileName = 'rekap-pendaftaran-pasien-' . ($this->search_month ?: 'semua') . '.xlsx';
        
        return response()->streamDownload(function() use ($data) {
            $writer = SimpleExcelWriter::create('php://output', 'xlsx');
            
            if ($data->isEmpty()) {
                $writer->addRow(['Data tidak ditemukan', '', '', '']);
            } else {
                $writer->addRows($data->toArray());
            }

            $writer->close();
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
};

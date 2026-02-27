<?php

use Livewire\Component;
use App\Models\Patient;
use App\Models\Encounter;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;

new class extends Component
{
    public $title = 'Dashboard Ringkasan';
    public $selectedMonth;
    public $encounterChartData = [];
    public $patientChartData = [];

    public function mount()
    {
        $this->selectedMonth = date('Y-m');
        $this->updateChartData();
    }

    public function updatedSelectedMonth()
    {
        $this->updateChartData();
        $this->dispatch('refreshCharts', 
            encounterData: $this->encounterChartData,
            patientData: $this->patientChartData
        );
    }

    #[Computed]
    public function stats()
    {
        return [
            'total_patients' => Patient::count(),
            'today_encounters' => Encounter::whereDate('visit_date', date('Y-m-d'))->count(),
            'monthly_encounters' => Encounter::where('visit_date', 'like', $this->selectedMonth . '%')->count(),
            'new_patients_today' => Patient::whereDate('created_at', date('Y-m-d'))->count(),
        ];
    }

    #[Computed]
    public function inprogressEncounters()
    {
        return Encounter::with('patient')
            ->where('status', 'inprogress')
            ->orderBy('visit_date', 'desc')
            ->limit(5)
            ->get();
    }

    protected function updateChartData()
    {
        $this->encounterChartData = $this->getEncounterChartData();
        $this->patientChartData = $this->getPatientChartData();
    }

    private function getEncounterChartData()
    {
        $daysInMonth = date('t', strtotime($this->selectedMonth . '-01'));
        $yearMonth = $this->selectedMonth;
        
        $results = Encounter::select(DB::raw('DATE(visit_date) as date'), DB::raw('count(*) as count'))
            ->where('visit_date', 'like', $yearMonth . '%')
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();

        $labels = [];
        $data = [];

        for ($i = 1; $i <= $daysInMonth; $i++) {
            $date = $yearMonth . '-' . sprintf('%02d', $i);
            $labels[] = $i;
            $data[] = $results[$date] ?? 0;
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }

    private function getPatientChartData()
    {
        // Get last 14 days of new patients
        $labels = [];
        $data = [];

        for ($i = 13; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $labels[] = date('d M', strtotime($date));
            $data[] = Patient::whereDate('created_at', $date)->count();
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }
};

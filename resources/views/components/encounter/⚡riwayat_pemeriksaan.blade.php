<?php

use App\Models\Encounter;
use Livewire\Component;

new class extends Component
{
    public $showHistoryModal = false;
    public $encounterHistory;

    public function mount($patient_id)
    {
        $this->encounterHistory = Encounter::where('patient_id', $patient_id)->get();
    }

    #[On('open-history-modal.{patient_id}')] 
    public function openHistory($patient_id)
    {
        $this->showHistoryModal = true;
        $this->encounterHistory = Encounter::where('patient_id', $patient_id)->get();
    }
};
?>

<div>
    <x-modal wire="showHistoryModal">
        <x-slot name="title">Riwayat Pemeriksaan</x-slot>
        <x-slot name="content">
            <div class="overflow-x-auto">
                <div class="flex flex-col gap-4">
                    @foreach ($encounterHistory as $history)
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium">{{ $history->created_at->format('d-m-Y') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </x-slot>
    </x-modal>
</div>
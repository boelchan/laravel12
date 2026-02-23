<?php

use App\Models\Encounter;
use Livewire\Component;
use Livewire\Attributes\On;

new class extends Component
{
    public $patient_id;
    public $showHistoryModal = false;
    public $encounterHistory = [];

    public function mount($patient_id = null)
    {

    }

    #[On('open-history-modal')] 
    public function openHistory($patient_id)
    {
        $this->showHistoryModal = true;
        
        $this->encounterHistory = Encounter::where('patient_id', $patient_id)
            ->with(['vitalSign', 'anthropometry'])
            ->orderBy('created_at', 'desc')
            ->get();
    }
};
?>

<div>
    <x-modal wire="showHistoryModal" title="Riwayat Pemeriksaan">
        <div class="overflow-x-auto">
            <table class="table-compact table w-full">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="p-2 text-left">Tanggal</th>
                        <th class="p-2 text-left">TTV</th>
                        <th class="p-2 text-left">Antropometri</th>
                        <th class="p-2 text-left">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($encounterHistory as $history)
                        <tr class="hover:bg-slate-50">
                            <td class="p-2">
                                <div class="font-medium text-slate-900">{{ $history->created_at->format('d-m-Y') }}</div>
                                <div class="text-xs text-slate-500">{{ $history->created_at->format('H:i') }}</div>
                            </td>
                            <td class="p-2 text-sm">
                                @if($history->vitalSign)
                                    <div>{{ $history->vitalSign->systolic ?? '-' }}/{{ $history->vitalSign->diastolic ?? '-' }} mmHg</div>
                                    <div class="text-xs text-slate-500">Suhu: {{ $history->vitalSign->body_temperature ?? '-' }}°C</div>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="p-2 text-sm">
                                @if($history->anthropometry)
                                    <div>BB: {{ $history->anthropometry->body_weight ?? '-' }} kg</div>
                                    <div>TB: {{ $history->anthropometry->body_height ?? '-' }} cm</div>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="p-2">
                                @if ($history->status == 'finished')
                                    <span class="badge badge-info badge-outline badge-xs">Selesai</span>
                                @else
                                    <span class="badge badge-ghost badge-xs">{{ $history->status }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-4 text-center text-slate-500">Tidak ada riwayat pemeriksaan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-modal>
</div>
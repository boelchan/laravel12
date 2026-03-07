<?php

use Livewire\Component;
use Livewire\Attributes\On;

new class extends Component 
{
    public $showModal = false;
    public $filePath = null;

    #[On('open_preview')]
    public function openPreview($path)
    {
        $this->filePath = asset('storage/' . $path);
        $this->showModal = true;
    }

    public function close()
    {
        $this->showModal = false;
        $this->filePath = null;
    }

};
?>

<div>
    <x-modal
        title="Preview Dokumen"
        wire="showModal"
        z-index="z-80"
    >
        <div class="flex justify-center">
            @if ($filePath)
                @php
                    $ext = pathinfo($filePath, PATHINFO_EXTENSION);
                @endphp

                @if (strtolower($ext) == 'pdf')
                    <iframe
                        class="h-[80vh] w-full rounded-lg"
                        src="{{ $filePath }}"
                    ></iframe>
                @else
                    <img
                        class="max-h-[80vh] w-auto rounded-lg"
                        src="{{ $filePath }}"
                        alt="Preview"
                    >
                @endif
            @endif
        </div>

        <x-slot:footer>
            <button class="btn btn-secondary btn-ghost" wire:click="close">Tutup</button>
        </x-slot:footer>
    </x-modal>
</div>

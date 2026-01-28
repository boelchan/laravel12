<div>
    @island(lazy: true)
        <form wire:submit.prevent="store">
            <div class="mb-4">
                <input type="hidden" wire:model="role_id">
                <x-input placeholder="Nama role" wire:model="name" />
            </div>
            <div class="mb-4">
                <x-button type="submit">Simpan Role Baru</x-button>
            </div>
        </form>
    @endisland
</div>

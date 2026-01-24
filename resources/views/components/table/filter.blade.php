<div>
    <!-- Bar atas -->
    <div class="flex justify-between">
        <div class="flex gap-2">
            <button type="button"
                wire:click="resetFilters" class="btn btn-soft btn-secondary w-10 h-10 lg:w-auto">
                <i class="ti ti-filter-2-x text-lg"></i>
                <span class="hidden lg:inline">Reset Filter</span>
            </button>
        </div>

        <!-- Slot tombol tambahan -->
        <div class="flex gap-2">
            {{ $action ?? '' }}
        </div>
    </div>

    <!-- Filter form -->
    <div>
        <div class="grid grid-cols-2 lg:gap-4 gap-x-4 gap-y-0 lg:grid-cols-4 xl:grid-cols-5">
            {{ $slot }}
        </div>
    </div>
</div>

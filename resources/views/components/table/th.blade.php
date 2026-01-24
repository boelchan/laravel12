@props(['sort' => null, 'label'=>"", 'width' => 'auto'])

@aware(['sortField', 'sortDirection'])

<th class="p-2" width="{{ $width }}">
    @if ($sort)
        <button type="button" class="flex items-center gap-1 cursor-pointer" wire:click="sortBy('{{ $sort }}')">
            {{ $label }}
            @if ($sortField === $sort)
                <i class="ti ti-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-lg"></i>
            @else
                <i class="ti ti-arrows-up-down text-neutral-300"></i>
            @endif
        </button>
    @else
        {{ $label }}
    @endif
</th>

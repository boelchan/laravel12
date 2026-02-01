@props(['sort' => null, 'label' => '', 'width' => 'auto'])

@aware(['sortField', 'sortDirection'])

<th class="p-2" width="{{ $width }}">
    @if ($sort)
        <button class="flex cursor-pointer items-center gap-1" type="button" wire:click="sortBy('{{ $sort }}')">
            {{ $label }}
            @if ($sortField === $sort)
                <i class="ti ti-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
            @else
                <i class="ti ti-arrows-sort text-neutral-400"></i>
            @endif
        </button>
    @else
        {{ $label }}
    @endif
</th>

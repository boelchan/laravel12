@props(['label' => ''])

<x-input :label="$label" {{ $attributes }}>
    <x-slot name="append">
        <x-button
            class="tooltip"
            data-tip="Reset"
            icon="x-mark"
            rounded="rounded-r-md"
            flat
            x-on:click="$wire.set('{{ $attributes->wire('model')->value() }}', '')"
        />
    </x-slot>
</x-input>

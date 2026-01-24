@props([
    'label' => '',
    'type' => 'text',
    'model' => '',
    'class' => '',
    'live' => false,
    'required' => false,
    
    // flatpicker
    'range' => false,
    'min' => null,
    'max' => null,
])

<fieldset class="fieldset">
    <legend class="fieldset-legend">
        {{ $label }}
        @if ($required)
            <span class="text-red-500">*</span>
        @endif
    </legend>

    @if ($type == 'date')
        <div
            x-data="{ value: @entangle($model) }"
            x-init="flatpickr($refs.input, {
                mode: '{{ $range ? 'range' : 'single' }}',
                locale: 'id',
                dateFormat: 'Y-m-d',

                @if ($min)
                minDate: '{{ $min }}',
                @endif

                @if ($max)
                maxDate: '{{ $max }}',
                @endif

                onChange(selectedDates, formattedStr) {
                    value = formattedStr;
                },
            })"
        >
            <input
                @if ($live)
                    wire:model.live="{{ $model }}"
                @else
                    wire:model="{{ $model }}"
                @endif
                x-ref="input"
                type="text"
                x-model="value"
                class="input w-full min-w-0 {{ $class }}"
                {{ $required ? 'required' : '' }}
            >
        </div>
    @else
        <input type="{{ $type }}"
            @if ($live)
                wire:model.live.debounce.500ms="{{ $model }}"
            @else
                wire:model="{{ $model }}"
            @endif
            id="{{ $model }}"
            name="{{ $model }}"
            class="input w-full min-w-0 {{ $class }}"
            {{ $required ? 'required' : '' }}
        />
    @endif

    <x-form.error :name="$model" />
</fieldset>

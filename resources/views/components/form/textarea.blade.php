@props(['class' => null, 'label' => '', 'model' => '', 'rows' => 3])

<fieldset class="fieldset">
    <legend class="fieldset-legend">{{ $label }}</legend>
    <textarea 
        wire:model="{{ $model }}" 
        name="{{ $model }}" 
        id="{{ $model }}"
        class="textarea w-full {{ $class ?? '' }}"
        rows="{{ $rows ?? 3 }}"
    ></textarea>
    <x-form.error :name="$model" />
</fieldset>
@props(['class' => null, 'label' => '', 'model' => '', 'options' => []])

{{-- 
<x-form.radio label="Status" model="description" :options="[['value' => 'paid', 'label' => 'Paid'], ['value' => 'unpaid', 'label' => 'Unpaid']]" /> 
--}}

<fieldset class="fieldset">
    <legend class="fieldset-legend">{{ $label }}</legend>
    <div class="flex gap-4">
        @foreach ($options as $opt)
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="radio" wire:model="{{ $model }}" name="{{ $model }}" value="{{ $opt['value'] }}" class="radio" />
                <span>{{ $opt['label'] }}</span>
            </label>
        @endforeach
    </div>
    <x-form.error :name="$model" />
</fieldset>

@props(['name', 'class' => 'text-error'])
<div>
    @if ($errors->has($name))
        <span class="{{ $class }}">
            {{ $errors->first($name) }}
        </span>
    @endif
</div>

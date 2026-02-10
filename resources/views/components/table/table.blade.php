@props([
    'paginate' => null, // data collection (paginator)
    'class' => 'table ',
])

<div class="mt-4 overflow-x-auto rounded border border-slate-200">
    <table class="{{ $class }}" {{ $attributes }}>
        {{ $slot }}
    </table>
</div>
<div class="mt-3">
    {{ $paginate->links('components.table.pagination') }}
</div>

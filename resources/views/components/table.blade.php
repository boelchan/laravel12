@props([
    'paginate' => null, // data collection (paginator)
])

<div class="mt-4 overflow-x-auto rounded border border-slate-200">
    <table class="table">
        {{ $slot }}
    </table>
</div>
<div class="mt-3">
    {{ $paginate->links('components.table.pagination') }}
</div>

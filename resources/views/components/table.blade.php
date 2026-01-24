@props([
    'paginate' => null, // data collection (paginator)
])

<div class="overflow-x-auto rounded border border-slate-200 mt-4">
    <table class="table">
        {{ $slot }}
    </table>
</div>
<div class="mt-3">
    {{ $paginate->links('components.table.pagination') }}
</div>

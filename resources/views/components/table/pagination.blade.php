<nav role="navigation" class="flex flex-col items-center justify-between gap-2 sm:flex-row">
    @if ($paginator->total() > $this->perPage)
        <select wire:model.change="perPage" class="select w-16 flex-none pr-0 input-sm">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
    @endif
    <div class="flex-1">
        @if ($paginator->total() === $paginator->lastItem())
            <p class="text-sm leading-5 text-gray-700 dark:text-gray-400">
                Tampil
                <span class="font-medium">{{ $paginator->total() }}</span>
                data
            </p>
        @elseif ($paginator->total() === 0)
        @else
            <p class="text-sm leading-5 text-gray-700 dark:text-gray-400">
                Tampil
                @if ($paginator->firstItem())
                    <span class="font-medium">{{ $paginator->firstItem() }}</span>
                    -
                    <span class="font-medium">{{ $paginator->lastItem() }}</span>
                @else
                    {{ $paginator->count() }}
                @endif
                dari
                <span class="font-medium">{{ $paginator->total() }}</span>
                data
            </p>

        @endif
    </div>
    @if ($paginator->hasPages())
        <div class="join">
            {{-- Previous Page --}}
            @if ($paginator->onFirstPage())
            @else
                <button type="button" wire:click="previousPage" class="join-item btn btn-ghost btn-circle btn-primary btn-sm">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="1.5"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>
                </button>
            @endif

            {{-- Numbers --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <button type="button" class="join-item">{{ $element }}</button>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <button type="button" class="join-item btn btn-soft btn-circle btn-primary btn-sm">{{ $page }}</button>
                        @else
                            <button type="button" wire:click="gotoPage({{ $page }})" class="join-item btn btn-ghost btn-circle btn-primary btn-sm">{{ $page }}</button>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page --}}
            @if ($paginator->hasMorePages())
                <button type="button" wire:click="nextPage" class="join-item btn btn-ghost btn-circle btn-primary btn-sm">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="1.5"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-right"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>
                </button>
            @else
            @endif
        </div>
    @endif
</nav>

<nav class="flex flex-col items-center justify-between gap-2 sm:flex-row" role="navigation">
    @if ($paginator->total() > 10)
        <select class="select input-sm w-16 flex-none pr-0" wire:model.live="perPage">
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
                <button class="join-item btn btn-ghost btn-circle btn-primary btn-sm" type="button" wire:click="previousPage">
                    <svg
                        class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left"
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M15 6l-6 6l6 6" />
                    </svg>
                </button>
            @endif

            {{-- Numbers --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <button class="join-item" type="button">{{ $element }}</button>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <button class="join-item btn btn-soft btn-circle btn-primary btn-sm" type="button">{{ $page }}</button>
                        @else
                            <button class="join-item btn btn-ghost btn-circle btn-primary btn-sm" type="button"
                                wire:click="gotoPage({{ $page }})"
                            >{{ $page }}</button>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page --}}
            @if ($paginator->hasMorePages())
                <button class="join-item btn btn-ghost btn-circle btn-primary btn-sm" type="button" wire:click="nextPage">
                    <svg
                        class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-right"
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M9 6l6 6l-6 6" />
                    </svg>
                </button>
            @else
            @endif
        </div>
    @endif
</nav>

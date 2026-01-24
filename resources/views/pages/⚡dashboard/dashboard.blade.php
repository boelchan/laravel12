<div class="space-y-6">
    <h1 class="text-2xl font-bold ">{{ $title }}</h1>

    @island(lazy: true)
        <div>
            Revenue

            <button type="button" class="btn" wire:click="$refresh">Refresh</button>
        </div>
    @endisland

</div>

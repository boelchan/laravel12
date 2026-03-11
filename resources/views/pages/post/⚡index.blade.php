<?php

use App\Models\Post;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use TallStackUi\Traits\Interactions;
use Illuminate\Support\Facades\Storage;
use App\Livewire\Traits\WithTableX;

new class extends Component
{
    use WithTableX, Interactions;

    public $sortFieldDefault = 'created_at';
    public $sortDirectionDefault = 'desc';
    public $search_judul;
    
    #[Computed]
    public function dataTable()
    {
        return Post::query()
            ->when($this->search_judul, fn($q) => $q->where('judul', 'like', '%' . $this->search_judul . '%'))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function delete($id)
    {
        $post = Post::findOrFail($id);
        
        if ($post->gambar) {
            Storage::disk('public')->delete($post->gambar);
        }

        $post->delete();
        $this->toast()->success('Pamflet berhasil dihapus')->send();
    }
};
?>

<div>
    <div class="flex justify-between align-middle">
        <div>
            <h1 class="text-2xl font-medium text-slate-900">Pamflet</h1>
            <div class="breadcrumbs p-0 text-xs text-slate-500">
                <ul>
                    <li><a href="{{ route('dashboard') }}"><i class="ti ti-home"></i></a></li>
                    <li>Pamflet</li>
                    <li>Daftar</li>
                </ul>
            </div>
        </div>
        <a class="btn btn-primary btn-sm" href="{{ route('post.create') }}" wire:navigate>
            <i class="ti ti-plus text-lg"></i> Tambah
        </a>
    </div>

    <div class="mt-6">
        {{-- filter --}}
        <div class="rounded-xl border border-slate-100 bg-white p-4 shadow-sm">
            <div class="flex items-center gap-2 mb-4">
                <span class="font-semibold text-slate-800">Filter Pencarian</span>
                <button class="btn btn-soft btn-error btn-xs w-6" type="button" wire:click="resetFilters">
                    <i class="ti ti-filter-x text-lg"></i>
                </button>
            </div>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
                <x-input label="Judul Pamflet" placeholder="Cari judul..." wire:model.live.debounce.500ms="search_judul" clearable />
            </div>
        </div>
        {{-- end filter --}}

        <div class="mt-6">
            <x-table :paginate="$this->dataTable">
                <x-table.thead class="bg-slate-50" :sortDirection="$sortDirection" :sortField="$sortField">
                    <x-table.th width="5%" label="No" />
                    <x-table.th label="Gambar" width="15%" />
                    <x-table.th label="Judul" />
                    <x-table.th label="Tanggal" sort="created_at" />
                    <x-table.th label="Publish" sort="publish" width="10%" />
                    <x-table.th width="10%" label="Aksi" />
                </x-table.thead>

                <tbody>
                    @forelse ($this->dataTable as $index => $post)
                        <tr class="bg-white hover:bg-neutral-50 transition-colors" wire:key="post-{{ $post->id }}">
                            <td class="p-2"> {{ $perPage * ($this->dataTable->currentPage() - 1) + $index + 1 }} </td>
                            <td class="p-2">
                                @if($post->gambar)
                                    <img src="{{ Storage::url($post->gambar) }}" class="h-12 w-20 rounded-lg object-cover shadow-sm border border-slate-100">
                                @else
                                    <div class="flex h-12 w-20 items-center justify-center rounded-lg bg-slate-50 text-slate-300 border border-dashed border-slate-200">
                                        <i class="ti ti-photo-off text-xl"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="p-2"> {{ $post->judul }} </td>
                            <td class="p-2"> {{ $post->created_at->format('d-m-Y H:i') }} </td>
                            <td class="p-2">
                                @if ($post->publish === 'ya')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-success/10 px-2.5 py-0.5 text-xs font-medium text-success">
                                        <i class="ti ti-check text-sm"></i> Ya
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-error/10 px-2.5 py-0.5 text-xs font-medium text-error">
                                        <i class="ti ti-x text-sm"></i> Tidak
                                    </span>
                                @endif
                            </td>
                            <td class="p-2">
                                <div class="flex justify-center gap-2">
                                    <a class="btn btn-sm btn-primary btn-square" href="{{ route('post.edit', [$post->id, Illuminate\Support\Str::uuid()]) }}"
                                        title="Ubah" wire:navigate
                                    >
                                        <i class="ti ti-edit text-lg"></i>
                                    </a>

                                    <button class="btn btn-sm btn-square btn-error btn-ghost" title="Hapus"
                                        wire:click="$js.confirmDelete({{ $post->id }}, '{{ addslashes($post->judul) }}')"
                                    >
                                        <i class="ti ti-trash text-lg"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="p-8 text-center text-slate-400" colspan="6">
                                <div class="flex flex-col items-center">
                                    <i class="ti ti-notes-off text-4xl mb-2 opacity-20"></i>
                                    <p>Tidak ada data pamflet</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </x-table>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.$js.confirmDelete = (id, judul) => {
                $tsui.interaction('dialog')
                    .wireable()
                    .question('Hapus Pamflet?', 'Apakah Anda yakin ingin menghapus pamflet "' + judul + '"?')
                    .cancel('Batal')
                    .confirm('Ya, Hapus', 'delete', id)
                    .send();
            }
        });
    </script>
    @endpush
</div>
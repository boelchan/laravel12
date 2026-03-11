<?php

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use TallStackUi\Traits\Interactions;

new class extends Component
{
    use WithFileUploads, Interactions;

    public $judul;
    public $slug;
    public $isi;
    public $gambar;
    public $publish = 'ya';

    protected $rules = [
        'judul' => 'required|max:250|unique:posts,judul',
        'gambar' => 'required|image|max:2048', // 2MB Max
        'publish' => 'required|in:ya,tidak',
    ];

    public function updatedJudul($value)
    {
        $this->slug = Str::slug($value);
    }

    public function save()
    {
        $this->validate();

        $path = $this->gambar->store('posts', 'public');

        Post::create([
            'judul' => $this->judul,
            'slug' => $this->slug,
            'isi' => $this->isi,
            'gambar' => $path,
            'publish' => $this->publish,
        ]);

        $this->toast()->success('Pamflet berhasil ditambahkan')->send();
        return $this->redirect(route('post.index'), navigate: true);
    }
};
?>

<div>
    <div class="flex justify-between align-middle">
        <div>
            <h1 class="text-2xl font-medium text-slate-900">Tambah Pamflet</h1>
            <div class="breadcrumbs p-0 text-xs text-slate-500">
                <ul>
                    <li><a href="{{ route('dashboard') }}"><i class="ti ti-home"></i></a></li>
                    <li><a href="{{ route('post.index') }}">Pamflet</a></li>
                    <li>Tambah</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="mt-6 max-w-4xl">
        <x-card class="bg-white">
            <form wire:submit="save" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-4">
                        <x-input label="Judul *" placeholder="Masukkan judul pamflet" wire:model.blur="judul" />
                    </div>
                    
                    <div class="space-y-4">
                        <x-upload label="Gambar *" 
                            wire:model="gambar" 
                            accept="image/*"
                            hint="Maksimal 2MB"
                        >
                            @if ($gambar)
                                <img src="{{ $gambar->temporaryUrl() }}" class="mt-2 h-32 w-full object-cover rounded shadow-sm">
                            @endif
                        </x-upload>
                    </div>
                </div>

                <x-textarea label="Isi Pamflet" placeholder="Tuliskan isi pamflet di sini..." wire:model="isi" rows="10" />
                
                <x-select.native
                    label="Publish *"
                    :options="[['label' => 'Ya', 'value' => 'ya'], ['label' => 'Tidak', 'value' => 'tidak']]"
                    wire:model="publish"
                />

                <div class="flex justify-end gap-2 mt-6">
                    <a class="btn btn-ghost" href="{{ route('post.index') }}" wire:navigate>Batal</a>
                    <button class="btn btn-primary" type="submit">Simpan</button>
                </div>
            </form>
        </x-card>
    </div>
</div>
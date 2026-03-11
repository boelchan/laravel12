<?php

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use TallStackUi\Traits\Interactions;
use Illuminate\Support\Facades\Storage;

new class extends Component {
    use WithFileUploads, Interactions;

    public Post $post;
    public $judul;
    public $slug;
    public $isi;
    public $gambar;
    public $existing_gambar;
    public $publish;

    public function mount(Post $post)
    {
        $this->post = $post;
        $this->judul = $post->judul;
        $this->slug = $post->slug;
        $this->isi = $post->isi;
        $this->existing_gambar = $post->gambar;
        $this->publish = $post->publish;
    }

    protected function rules()
    {
        return [
            'judul' => 'required|max:250|unique:posts,judul,' . $this->post->id,
            'gambar' => 'nullable|image|max:2048',
            'publish' => 'required|in:ya,tidak',
        ];
    }

    public function updatedJudul($value)
    {
        $this->slug = Str::slug($value);
    }

    public function save()
    {
        $this->validate();

        $data = [
            'judul' => $this->judul,
            'slug' => $this->slug,
            'isi' => $this->isi,
            'publish' => $this->publish,
        ];

        if ($this->gambar) {
            // Delete old image
            if ($this->existing_gambar) {
                Storage::disk('public')->delete($this->existing_gambar);
            }
            $data['gambar'] = $this->gambar->store('posts', 'public');
        }

        $this->post->update($data);

        $this->toast()->success('Pamflet berhasil diperbarui')->send();
        return $this->redirect(route('post.index'), navigate: true);
    }
};
?>

<div>
    <div class="flex justify-between align-middle">
        <div>
            <h1 class="text-2xl font-medium text-slate-900">Ubah Pamflet</h1>
            <div class="breadcrumbs p-0 text-xs text-slate-500">
                <ul>
                    <li><a href="{{ route('dashboard') }}"><i class="ti ti-home"></i></a></li>
                    <li><a href="{{ route('post.index') }}">Pamflet</a></li>
                    <li>Ubah</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="mt-6 max-w-4xl">
        <x-card class="bg-white">
            <form
                class="space-y-4"
                wire:submit="save"
            >
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <x-input
                        label="Judul"
                        placeholder="Masukkan judul pamflet"
                        wire:model.blur="judul"
                    />

                    <x-upload
                        label="Gambar"
                        wire:model="gambar"
                        accept="image/*"
                        hint="Kosongkan jika tidak ingin mengubah gambar. Maksimal 2MB"
                    >
                        @if ($gambar)
                            <img
                                class="mt-2 h-32 w-full rounded object-cover shadow-sm"
                                src="{{ $gambar->temporaryUrl() }}"
                            >
                        @elseif ($existing_gambar)
                            <img
                                class="mt-2 h-32 w-full rounded border object-cover shadow-sm"
                                src="{{ Storage::url($existing_gambar) }}"
                            >
                        @endif
                    </x-upload>
                    <x-textarea
                        label="Isi Pamflet"
                        placeholder="Tuliskan isi pamflet di sini..."
                        wire:model="isi"
                        rows="10"
                    />
                    <x-select.native
                        label="Publish"
                        :options="[['label' => 'Ya', 'value' => 'ya'], ['label' => 'Tidak', 'value' => 'tidak']]"
                        wire:model="publish"
                    />

                    <div class="mt-6 flex justify-end gap-2">
                        <a
                            class="btn btn-ghost"
                            href="{{ route('post.index') }}"
                            wire:navigate
                        >Batal</a>
                        <button
                            class="btn btn-primary"
                            type="submit"
                        >Simpan Perubahan</button>
                    </div>
            </form>
        </x-card>
    </div>
</div>

<?php

use App\Livewire\Traits\WithTableX;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Computed;
use WireUi\Traits\WireUiActions;

new class extends Component
{
    use WireUiActions, WithTableX;

    public $sortFieldDefault = 'name';
    public $sortDirectionDefault = 'asc';

    public $search_name = '';
    public $search_email = '';

    #[Computed]
    public function dataTable()
    {
        return User::with('roles')
            ->when($this->search_name, fn($q) => $q->where('name', 'like', '%' . $this->search_name . '%'))
            ->when($this->search_email, fn($q) => $q->where('email', 'like', '%' . $this->search_email . '%'))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage)
            ->onEachSide(1);
    }

    public function confirmDelete($id, $name)
    {
        $this->dialog()->confirm([
            'title'       => "Hapus {$name}?",
            'description' => 'Data yang dihapus tidak dapat dikembalikan',
            'icon'        => 'error',
            'accept'      => [
                'label'  => 'Ya, Hapus',
                'method' => 'delete',
                'params' => $id,
            ],
            'reject' => [
                'label'  => 'Batal',
                'color'  => 'secondary',
            ],
        ]);
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        $this->notification()->success('User berhasil dihapus');
    }
};

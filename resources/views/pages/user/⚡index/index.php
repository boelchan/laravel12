<?php

use App\Models\User;
use App\Livewire\Traits\WithTableX;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    use WithTableX;

    public $title = 'User';

    public $search_name = '';
    public $search_email = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';
    public $perPage = 10;

    #[Computed]
    public function get_data()
    {
        $data = User::when($this->search_name, fn($q) => $q->where('name', 'like', '%' . $this->search_name . '%'))
            ->when($this->search_email, fn($q) => $q->where('email', 'like', '%' . $this->search_email . '%'))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage)
            ->onEachSide(1);

        return $this->applyTable($data);
    }
};

<?php

namespace App\Livewire\Traits;

use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

trait WithTableX
{
    use WithoutUrlPagination, WithPagination;

    public $perPage = 10;

    public bool $open = false;

    public $sortField = 'id';

    public $sortDirection = 'desc';

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage(); // supaya balik ke page 1 kalau perPage diubah
    }

    public function resetFilters()
    {
        foreach (get_object_vars($this) as $property => $value) {
            if (str_starts_with($property, 'search_')) {
                $this->$property = null;
            }
        }
    }

    public function applyTable($query)
    {
        return $query
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage)
            ->onEachSide(1);
    }
}

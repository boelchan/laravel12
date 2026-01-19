<?php

use Livewire\Component;

new class extends Component
{
    public $title = 'Dashboard';
};
?>

<div class="space-y-6">
    <h1 class="text-2xl font-bold">{{ $title }}</h1>
</div>

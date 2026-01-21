<?php
use Livewire\Component;
use Mckenziearts\Notify\Action\NotifyAction;

new class extends Component {
    public $title = 'Dashboard';
    public $select = 'ss';
    public $model1 = '';

    public function mount()
    {
        notify()->success()->title('⚡️ Laravel Notify is awesome!')->send();

        notify()
            ->success()
            ->title('User deleted successfully')
            ->actions([NotifyAction::make()->label('Undo')->action(route('dashboard')), NotifyAction::make()->label('View All')->url(route('dashboard'))])
            ->send();
    }

    public function store()
    {
        User::get(1);
    }
};
?>

<div class="space-y-6">
    <h1 class="text-2xl font-bold">{{ $title }}</h1>
    <h5>{{ $select }}</h5>
    <button class="btn btn-primary">ajdklajs</button>

    <x-select placeholder="Select one status" :options="['Active', 'Pending', 'Stuck', 'Done']" wire:model.live="select" />
    <input type="text" class="input">
    <x-input label="Name" placeholder="your name" type="number" corner="Ex: John" {{-- class="input" --}} />

    <span class="text-sm dark:text-gray-400">
        Model: {{ $model1 }}
    </span>

    <x-datetime-picker wire:model.defer="periode" label="Appointment Date" range placeholder="Appointment Date" without-time />

</div>

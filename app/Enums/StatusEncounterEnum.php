<?php

namespace App\Enums;

enum StatusEncounterEnum: string
{
    case REGISTERED = 'registered';
    case ARRIVED = 'arrived';
    case INPROGRESS = 'inprogress';
    case FINISHED = 'finished';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            static::REGISTERED => 'Baru',
            static::ARRIVED => 'Datang',
            static::INPROGRESS => 'Dalam Proses',
            static::FINISHED => 'Selesai',
            static::CANCELLED => 'Batal',
        };
    }
    public function badge(): string
    {
        return match ($this) {
            static::REGISTERED => '<span class="badge badge-soft badge-info h-auto">' . static::REGISTERED->label() . '</span>',
            static::ARRIVED => '<span class="badge badge-soft badge-primary h-auto">' . static::ARRIVED->label() . '</span>',
            static::INPROGRESS => '<span class="badge badge-soft badge-warning h-auto">' . static::INPROGRESS->label() . '</span>',
            static::FINISHED => '<span class="badge badge-soft badge-success h-auto">' . static::FINISHED->label() . '</span>',
            static::CANCELLED => '<span class="badge badge-soft badge-error h-auto">' . static::CANCELLED->label() . '</span>',
        };
    }

    public static function choices(): array
    {
        return [
            [
                'value' => static::REGISTERED->value,
                'label' => static::REGISTERED->label(),
            ],
            [
                'value' => static::ARRIVED->value,
                'label' => static::ARRIVED->label(),
            ],
            [
                'value' => static::INPROGRESS->value,
                'label' => static::INPROGRESS->label(),
            ],
            [
                'value' => static::FINISHED->value,
                'label' => static::FINISHED->label(),
            ],
            [
                'value' => static::CANCELLED->value,
                'label' => static::CANCELLED->label(),
            ],
        ];
    }
}

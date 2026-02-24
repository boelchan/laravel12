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
            static::REGISTERED => '<span class="badge badge-info">' . static::REGISTERED->label() . '</span>',
            static::ARRIVED => '<span class="badge badge-primary">' . static::ARRIVED->label() . '</span>',
            static::INPROGRESS => '<span class="badge badge-warning">' . static::INPROGRESS->label() . '</span>',
            static::FINISHED => '<span class="badge badge-success">' . static::FINISHED->label() . '</span>',
            static::CANCELLED => '<span class="badge badge-error">' . static::CANCELLED->label() . '</span>',
        };
    }

    public static function choices(): array
    {
        return [
            static::REGISTERED->value => static::REGISTERED->label(),
            static::ARRIVED->value => static::ARRIVED->label(),
            static::INPROGRESS->value => static::INPROGRESS->label(),
            static::FINISHED->value => static::FINISHED->label(),
            static::CANCELLED->value => static::CANCELLED->label(),
        ];
    }
}

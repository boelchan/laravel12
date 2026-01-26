<?php

namespace App\Enums;

enum RolesEnum: string
{
    case ADMINISTRATOR = 'administrator';
    case DOKTER = 'dokter';
    case PERAWAT = 'perawat';
    case PASIEN = 'pasien';
    case OPERATOR = 'operator';

    public function label(): string
    {
        return match ($this) {
            static::ADMINISTRATOR => 'Administrator',
            static::DOKTER => 'Dokter',
            static::PERAWAT => 'Perawat',
            static::PASIEN => 'Pasien',
            static::OPERATOR => 'Operator',
        };
    }

    public static function choices(): array
    {
        return [
            static::ADMINISTRATOR->value => static::ADMINISTRATOR->label(),
            static::DOKTER->value => static::DOKTER->label(),
            static::PERAWAT->value => static::PERAWAT->label(),
            static::PASIEN->value => static::PASIEN->label(),
            static::OPERATOR->value => static::OPERATOR->label(),
        ];
    }
}

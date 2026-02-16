<?php

namespace App\Enums;

enum GenderEnum: int
{
    case UNKNOWN = 0;
    case MALE = 1;
    case FEMALE = 2;
    case UNSPECIFIED = 3;

    public function label(): string
    {
        return match ($this) {
            static::UNKNOWN => 'Tidak diketahui',
            static::MALE => 'Laki-laki',
            static::FEMALE => 'Perempuan',
            static::UNSPECIFIED => 'Tidak ditentukan',
        };
    }

    public static function choices(): array
    {
        return [
            ['label' => 'Tidak diketahui', 'value' => static::UNKNOWN->value],
            ['label' => 'Laki-laki', 'value' => static::MALE->value],
            ['label' => 'Perempuan', 'value' => static::FEMALE->value],
            ['label' => 'Tidak ditentukan', 'value' => static::UNSPECIFIED->value],
        ];
    }
}

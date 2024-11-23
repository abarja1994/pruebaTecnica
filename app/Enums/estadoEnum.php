<?php

namespace App\Enums;

enum EstadoEnum: int
{
    case Inactivo = 0;
    case Activo = 1;

    public function label(): string
    {
        return match ($this) {
            self::Activo => 'Activo',
            self::Inactivo => 'Inactivo',
        };
    }
}


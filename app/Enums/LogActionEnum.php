<?php

namespace App\Enums;

enum LogActionEnum: string
{
    case Registro = 'create';
    case Edicion = 'edit';
    case Eliminacion = 'delete';

    public function label(): string
    {
        return match ($this) {
            self::Registro => 'Registro',
            self::Edicion => 'Edición',
            self::Eliminacion => 'Eliminación',
        };
    }
}

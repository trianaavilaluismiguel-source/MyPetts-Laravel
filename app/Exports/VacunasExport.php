<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VacunasExport implements FromArray, WithHeadings
{
    public function __construct(private array $datos) {}

    public function array(): array
    {
        return array_map(fn ($fila) => [
            date('d/m/Y', strtotime($fila->fecha_aplicacion)),
            $fila->nombre_producto,
            $fila->tipo,
            $fila->nombre_mascota,
            $fila->nombre_veterinario,
            date('d/m/Y', strtotime($fila->fecha_proxima_dosis)),
        ], $this->datos);
    }

    public function headings(): array
    {
        return ['Fecha aplicación', 'Producto', 'Tipo', 'Mascota', 'Veterinario', 'Próxima dosis'];
    }
}

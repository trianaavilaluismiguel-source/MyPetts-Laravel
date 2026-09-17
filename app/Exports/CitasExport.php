<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CitasExport implements FromArray, WithHeadings
{
    public function __construct(private array $datos) {}

    public function array(): array
    {
        return array_map(fn ($fila) => [
            date('d/m/Y', strtotime($fila->fecha)),
            date('h:i A', strtotime($fila->hora)),
            $fila->nombre_mascota,
            $fila->nombre_veterinario,
            $fila->tipo_consulta,
            $fila->estado,
        ], $this->datos);
    }

    public function headings(): array
    {
        return ['Fecha', 'Hora', 'Mascota', 'Veterinario', 'Consulta', 'Estado'];
    }
}

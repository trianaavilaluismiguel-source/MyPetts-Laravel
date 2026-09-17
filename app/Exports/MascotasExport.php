<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MascotasExport implements FromArray, WithHeadings
{
    public function __construct(private array $datos) {}

    public function array(): array
    {
        $especies = array_unique(array_merge(array_keys($this->datos['actual']), array_keys($this->datos['anterior'])));

        return array_map(fn ($especie) => [
            $especie,
            $this->datos['actual'][$especie] ?? 0,
            $this->datos['anterior'][$especie] ?? 0,
        ], $especies);
    }

    public function headings(): array
    {
        return ['Especie', 'Período actual', 'Período anterior'];
    }
}

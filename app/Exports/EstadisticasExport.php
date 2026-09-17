<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EstadisticasExport implements FromArray, WithHeadings
{
    public function __construct(private array $datos, private string $desde, private string $hasta) {}

    public function array(): array
    {
        $filas = [
            ['Periodo', $this->desde.' a '.$this->hasta],
            ['Mascotas registradas', $this->datos['totalMascotas']],
            ['Citas completadas', $this->datos['citasCompletadas']],
            ['Citas canceladas', $this->datos['citasCanceladas']],
            ['Citas agendadas', $this->datos['citasAgendadas']],
            ['Vacunas/desparasitaciones aplicadas', $this->datos['vacunasAplicadas']],
            ['', ''],
            ['Usuarios activos por rol', ''],
        ];

        foreach ($this->datos['usuariosPorRol'] as $fila) {
            $filas[] = [$fila->nombre_rol, $fila->total];
        }

        return $filas;
    }

    public function headings(): array
    {
        return ['Indicador', 'Valor'];
    }
}

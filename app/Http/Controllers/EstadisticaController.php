<?php

namespace App\Http\Controllers;

use App\Exports\EstadisticasExport;
use App\Models\Estadistica;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class EstadisticaController extends Controller
{
    // HU-09: panel de estadísticas generales del Administrador
    public function index(Request $request)
    {
        // HU-09 Esc.2: si el sistema no tiene datos mínimos, no calculamos nada más
        if (! Estadistica::hayDatosSuficientes()) {
            return view('estadisticas.index', ['sinDatos' => true]);
        }

        // HU-09 Esc.3: filtro de período (por defecto, el mes actual)
        $desde = $request->query('desde', now()->startOfMonth()->format('Y-m-d'));
        $hasta = $request->query('hasta', now()->endOfMonth()->format('Y-m-d'));

        $datos = $this->calcularIndicadores($desde, $hasta);

        // HU-09 Esc.4: comparativo contra un segundo período, si el usuario lo pidió
        $desde2 = $request->query('desde2', '');
        $hasta2 = $request->query('hasta2', '');
        $comparar = $request->has('comparar') && $desde2 !== '' && $hasta2 !== '';
        $datosComparacion = $comparar ? $this->calcularIndicadores($desde2, $hasta2) : null;

        return view('estadisticas.index', [
            'sinDatos' => false,
            'desde' => $desde,
            'hasta' => $hasta,
            'datos' => $datos,
            'comparar' => $comparar,
            'desde2' => $desde2,
            'hasta2' => $hasta2,
            'datosComparacion' => $datosComparacion,
        ]);
    }

    // Agrupa las 4 consultas de indicadores para un período dado
    private function calcularIndicadores(string $desde, string $hasta): array
    {
        $citas = Estadistica::citasPorEstado($desde, $hasta);

        return [
            'usuariosPorRol' => Estadistica::usuariosActivosPorRol(),
            'totalMascotas' => Estadistica::totalMascotasRegistradas(),
            'citasCompletadas' => $citas['completada'],
            'citasCanceladas' => $citas['cancelada'],
            'citasAgendadas' => $citas['agendada'] + $citas['reagendada'],
            'vacunasAplicadas' => Estadistica::vacunasAplicadas($desde, $hasta),
        ];
    }

    // HU-08: exporta el reporte del período filtrado como PDF
    public function exportarPdf(Request $request)
    {
        $desde = $request->query('desde', now()->startOfMonth()->format('Y-m-d'));
        $hasta = $request->query('hasta', now()->endOfMonth()->format('Y-m-d'));
        $datos = $this->calcularIndicadores($desde, $hasta);

        $pdf = Pdf::loadView('estadisticas.pdf', compact('datos', 'desde', 'hasta'));

        return $pdf->download("reporte_mypetts_{$desde}_a_{$hasta}.pdf");
    }

    // HU-08: exporta el mismo reporte como archivo Excel (.xlsx real)
    public function exportarExcel(Request $request)
    {
        $desde = $request->query('desde', now()->startOfMonth()->format('Y-m-d'));
        $hasta = $request->query('hasta', now()->endOfMonth()->format('Y-m-d'));
        $datos = $this->calcularIndicadores($desde, $hasta);

        return Excel::download(
            new EstadisticasExport($datos, $desde, $hasta),
            "reporte_mypetts_{$desde}_a_{$hasta}.xlsx"
        );
    }
}

<?php

namespace App\Http\Controllers;

use App\Exports\CitasExport;
use App\Exports\MascotasExport;
use App\Exports\VacunasExport;
use App\Models\Mascota;
use App\Models\Reporte;
use App\Models\Usuario;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReporteController extends Controller
{
    private const ROL_VETERINARIO = 2;

    private const TIPOS_VALIDOS = ['citas', 'vacunas', 'mascotas'];

    public function index(Request $request)
    {
        $tipo = $this->tipoValido($request->query('tipo', 'citas'));
        $desde = $request->query('desde', now()->startOfMonth()->format('Y-m-d'));
        $hasta = $request->query('hasta', now()->endOfMonth()->format('Y-m-d'));
        $mascotaId = $this->idOpcional($request->query('mascota_id', ''));
        $veterinarioId = $this->idOpcional($request->query('veterinario_id', ''));

        $sinDatos = ! Reporte::hayDatos($tipo, $desde, $hasta, $mascotaId, $veterinarioId);
        $datos = $sinDatos ? null : $this->obtenerDatos($tipo, $desde, $hasta, $mascotaId, $veterinarioId);

        return view('reportes.index', [
            'tipo' => $tipo,
            'desde' => $desde,
            'hasta' => $hasta,
            'mascotaId' => $mascotaId,
            'veterinarioId' => $veterinarioId,
            'mascotas' => Mascota::activas()->get(),
            'veterinarios' => Usuario::where('rol_id', self::ROL_VETERINARIO)->get(),
            'sinDatos' => $sinDatos,
            'datos' => $datos,
        ]);
    }

    public function exportarPdf(Request $request)
    {
        $tipo = $this->tipoValido($request->query('tipo', 'citas'));
        $desde = $request->query('desde', now()->startOfMonth()->format('Y-m-d'));
        $hasta = $request->query('hasta', now()->endOfMonth()->format('Y-m-d'));
        $mascotaId = $this->idOpcional($request->query('mascota_id', ''));
        $veterinarioId = $this->idOpcional($request->query('veterinario_id', ''));

        if (! Reporte::hayDatos($tipo, $desde, $hasta, $mascotaId, $veterinarioId)) {
            return redirect("/reporte?tipo={$tipo}&desde={$desde}&hasta={$hasta}")
                ->with('mensaje', 'No hay datos para el período seleccionado.');
        }

        $datos = $this->obtenerDatos($tipo, $desde, $hasta, $mascotaId, $veterinarioId);

        $pdf = Pdf::loadView("reportes.pdf-{$tipo}", compact('datos', 'desde', 'hasta'));

        return $pdf->download("reporte_{$tipo}_{$desde}_a_{$hasta}.pdf");
    }

    public function exportarExcel(Request $request)
    {
        $tipo = $this->tipoValido($request->query('tipo', 'citas'));
        $desde = $request->query('desde', now()->startOfMonth()->format('Y-m-d'));
        $hasta = $request->query('hasta', now()->endOfMonth()->format('Y-m-d'));
        $mascotaId = $this->idOpcional($request->query('mascota_id', ''));
        $veterinarioId = $this->idOpcional($request->query('veterinario_id', ''));

        if (! Reporte::hayDatos($tipo, $desde, $hasta, $mascotaId, $veterinarioId)) {
            return redirect("/reporte?tipo={$tipo}&desde={$desde}&hasta={$hasta}")
                ->with('mensaje', 'No hay datos para el período seleccionado.');
        }

        $datos = $this->obtenerDatos($tipo, $desde, $hasta, $mascotaId, $veterinarioId);
        $nombreArchivo = "reporte_{$tipo}_{$desde}_a_{$hasta}.xlsx";

        $export = match ($tipo) {
            'citas' => new CitasExport($datos),
            'vacunas' => new VacunasExport($datos),
            'mascotas' => new MascotasExport($datos),
        };

        return Excel::download($export, $nombreArchivo);
    }

    private function obtenerDatos(string $tipo, string $desde, string $hasta, ?int $mascotaId, ?int $veterinarioId)
    {
        return match ($tipo) {
            'citas' => Reporte::citasPorPeriodo($desde, $hasta),
            'vacunas' => Reporte::vacunasAplicadas($desde, $hasta, $mascotaId, $veterinarioId),
            'mascotas' => Reporte::mascotasAtendidasPorEspecie($desde, $hasta),
        };
    }

    private function tipoValido(string $tipo): string
    {
        return in_array($tipo, self::TIPOS_VALIDOS, true) ? $tipo : 'citas';
    }

    private function idOpcional(string $valor): ?int
    {
        return $valor !== '' ? (int) $valor : null;
    }
}

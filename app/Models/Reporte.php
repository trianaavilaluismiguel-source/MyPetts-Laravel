<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Reporte
{
    public static function citasPorPeriodo(string $desde, string $hasta): array
    {
        return DB::table('citas as c')
            ->join('mascotas as m', 'm.id', '=', 'c.mascota_id')
            ->join('usuarios as v', 'v.id', '=', 'c.veterinario_id')
            ->whereBetween('c.fecha', [$desde, $hasta])
            ->orderBy('c.fecha')->orderBy('c.hora')
            ->select('c.fecha', 'c.hora', 'c.tipo_consulta', 'c.estado', 'm.nombre as nombre_mascota', 'v.nombre as nombre_veterinario')
            ->get()->toArray();
    }

    public static function vacunasAplicadas(string $desde, string $hasta, ?int $mascotaId = null, ?int $veterinarioId = null): array
    {
        $query = DB::table('vacunas_desparasitaciones as vd')
            ->join('mascotas as m', 'm.id', '=', 'vd.mascota_id')
            ->join('usuarios as v', 'v.id', '=', 'vd.veterinario_id')
            ->whereBetween('vd.fecha_aplicacion', [$desde, $hasta]);

        if ($mascotaId !== null) {
            $query->where('vd.mascota_id', $mascotaId);
        }
        if ($veterinarioId !== null) {
            $query->where('vd.veterinario_id', $veterinarioId);
        }

        return $query->orderBy('vd.fecha_aplicacion')
            ->select('vd.nombre_producto', 'vd.tipo', 'vd.fecha_aplicacion', 'vd.fecha_proxima_dosis', 'm.nombre as nombre_mascota', 'v.nombre as nombre_veterinario')
            ->get()->toArray();
    }

    public static function mascotasAtendidasPorEspecie(string $desde, string $hasta): array
    {
        [$desdeAnt, $hastaAnt] = self::periodoAnterior($desde, $hasta);

        return [
            'actual' => self::conteoPorEspecie($desde, $hasta),
            'anterior' => self::conteoPorEspecie($desdeAnt, $hastaAnt),
        ];
    }

    private static function conteoPorEspecie(string $desde, string $hasta): array
    {
        $filas = DB::table('citas as c')
            ->join('mascotas as m', 'm.id', '=', 'c.mascota_id')
            ->where('c.estado', 'completada')
            ->whereBetween('c.fecha', [$desde, $hasta])
            ->groupBy('m.especie')
            ->orderByDesc(DB::raw('COUNT(DISTINCT c.mascota_id)'))
            ->select('m.especie', DB::raw('COUNT(DISTINCT c.mascota_id) as total'))
            ->get();

        $resultado = [];
        foreach ($filas as $fila) {
            $resultado[$fila->especie] = (int) $fila->total;
        }

        return $resultado;
    }

    private static function periodoAnterior(string $desde, string $hasta): array
    {
        $inicio = Carbon::parse($desde);
        $fin = Carbon::parse($hasta);
        $dias = $inicio->diffInDays($fin) + 1;

        $finAnterior = $inicio->copy()->subDay();
        $inicioAnterior = $finAnterior->copy()->subDays($dias - 1);

        return [$inicioAnterior->format('Y-m-d'), $finAnterior->format('Y-m-d')];
    }

    public static function hayDatos(string $tipo, string $desde, string $hasta, ?int $mascotaId = null, ?int $veterinarioId = null): bool
    {
        return match ($tipo) {
            'citas' => count(self::citasPorPeriodo($desde, $hasta)) > 0,
            'vacunas' => count(self::vacunasAplicadas($desde, $hasta, $mascotaId, $veterinarioId)) > 0,
            'mascotas' => array_sum(self::conteoPorEspecie($desde, $hasta)) > 0,
            default => false,
        };
    }
}

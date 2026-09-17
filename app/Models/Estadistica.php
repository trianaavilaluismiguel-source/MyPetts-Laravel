<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Estadistica
{
    public static function usuariosActivosPorRol(): array
    {
        return DB::table('roles as r')
            ->leftJoin('usuarios as u', function ($join) {
                $join->on('u.rol_id', '=', 'r.id')->where('u.activo', 1);
            })
            ->groupBy('r.id', 'r.nombre_rol')
            ->orderBy('r.id')
            ->select('r.nombre_rol', DB::raw('COUNT(u.id) as total'))
            ->get()->toArray();
    }

    public static function totalMascotasRegistradas(): int
    {
        return (int) DB::table('mascotas')->where('activa', 1)->count();
    }

    public static function citasPorEstado(string $desde, string $hasta): array
    {
        $filas = DB::table('citas')
            ->whereBetween('fecha', [$desde, $hasta])
            ->groupBy('estado')
            ->select('estado', DB::raw('COUNT(*) as total'))
            ->get();

        $resultado = ['agendada' => 0, 'completada' => 0, 'cancelada' => 0, 'reagendada' => 0];
        foreach ($filas as $fila) {
            $resultado[$fila->estado] = (int) $fila->total;
        }

        return $resultado;
    }

    public static function vacunasAplicadas(string $desde, string $hasta): int
    {
        return (int) DB::table('vacunas_desparasitaciones')
            ->whereBetween('fecha_aplicacion', [$desde, $hasta])
            ->count();
    }

    // si no hay datos mínimos (ni usuarios activos ni mascotas), no tiene sentido mostrar el panel
    public static function hayDatosSuficientes(): bool
    {
        $usuarios = DB::table('usuarios')->where('activo', 1)->count();
        $mascotas = DB::table('mascotas')->count();

        return $usuarios > 0 && $mascotas > 0;
    }
}

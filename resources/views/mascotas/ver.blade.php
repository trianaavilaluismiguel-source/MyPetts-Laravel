@extends('layouts.auth')

@section('titulo', $mascota->nombre)

@section('contenido')
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <span class="w-12 h-12 rounded-full bg-brand-100 flex items-center justify-center">
                <svg class="w-6 h-6 text-brand-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75a3 3 0 116 0 3 3 0 01-6 0zM13.5 12.75a3 3 0 116 0 3 3 0 01-6 0zM8.25 6.375a2.625 2.625 0 115.25 0 2.625 2.625 0 01-5.25 0zM6 19.5c0-2.485 2.686-4.5 6-4.5s6 2.015 6 4.5" />
                </svg>
            </span>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">{{ $mascota->nombre }}</h1>
                <p class="text-sm text-gray-500">{{ $mascota->especie }} · {{ $mascota->raza }}</p>
            </div>
        </div>
        <a href="/mascota/editar/{{ $mascota->id }}" class="bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium px-4 py-2.5 rounded-xl transition">
            Editar
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-brand-100 p-6 grid sm:grid-cols-2 gap-5 max-w-xl mb-6">
        <div>
            <p class="text-xs text-gray-500">Sexo</p>
            <p class="text-sm font-medium text-gray-900">{{ $mascota->sexo }}</p>
        </div>
        <div>
            <p class="text-xs text-gray-500">Edad</p>
            <p class="text-sm font-medium text-gray-900">{{ $mascota->edad }} años</p>
        </div>
        <div>
            <p class="text-xs text-gray-500">Peso</p>
            <p class="text-sm font-medium text-gray-900">{{ $mascota->peso }} kg</p>
        </div>
        <div>
            <p class="text-xs text-gray-500">Estado de salud</p>
            @if ($mascota->estado_salud === 'al_dia')
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700">Al día</span>
            @else
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700">Pendiente</span>
            @endif
        </div>
        <div class="sm:col-span-2">
            <p class="text-xs text-gray-500">Dueño</p>
            <p class="text-sm font-medium text-gray-900">{{ $mascota->dueno->nombre ?? 'N/A' }}</p>
        </div>
    </div>

    <div class="flex gap-4 text-sm">
        <a href="/historial/verHistorial/{{ $mascota->id }}" class="text-brand-600 hover:underline">Ver historial clínico</a>
        <a href="/vacuna/verVacunas/{{ $mascota->id }}" class="text-brand-600 hover:underline">Ver vacunas</a>
        <a href="/mascota" class="text-gray-500 hover:underline">Volver</a>
    </div>
@endsection
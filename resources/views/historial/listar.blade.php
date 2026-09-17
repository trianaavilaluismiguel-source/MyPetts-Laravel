@extends('layouts.auth')

@section('titulo', 'Historial clínico')

@section('contenido')
    <h1 class="text-2xl font-bold text-gray-900 tracking-tight mb-6">Historial clínico</h1>
    <p class="text-sm text-gray-500 mb-4">Selecciona una mascota para ver su historial:</p>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($mascotas as $mascota)
            <a href="/historial/verHistorial/{{ $mascota->id }}"
               class="flex items-center gap-3 bg-white rounded-2xl border border-brand-100 p-4 hover:shadow-md transition">
                <span class="w-10 h-10 rounded-full bg-brand-100 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-brand-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75a3 3 0 116 0 3 3 0 01-6 0zM13.5 12.75a3 3 0 116 0 3 3 0 01-6 0zM8.25 6.375a2.625 2.625 0 115.25 0 2.625 2.625 0 01-5.25 0zM6 19.5c0-2.485 2.686-4.5 6-4.5s6 2.015 6 4.5" />
                    </svg>
                </span>
                <span>
                    <span class="block font-medium text-gray-900">{{ $mascota->nombre }}</span>
                    <span class="block text-xs text-gray-500">{{ $mascota->especie }}</span>
                </span>
            </a>
        @endforeach
    </div>

    <div class="mt-5">{{ $mascotas->links() }}</div>
@endsection
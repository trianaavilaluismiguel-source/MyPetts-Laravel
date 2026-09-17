@extends('layouts.auth')

@section('titulo', 'Vacunas y desparasitaciones')

@section('contenido')
    <h1 class="text-2xl font-bold text-gray-900 tracking-tight mb-6">Vacunas y desparasitaciones</h1>
    <p class="text-sm text-gray-500 mb-4">Selecciona una mascota:</p>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($mascotas as $mascota)
            <a href="/vacuna/verVacunas/{{ $mascota->id }}"
               class="flex items-center gap-3 bg-white rounded-2xl border border-brand-100 p-4 hover:shadow-md transition">
                <span class="w-10 h-10 rounded-full bg-brand-100 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-brand-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5" />
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
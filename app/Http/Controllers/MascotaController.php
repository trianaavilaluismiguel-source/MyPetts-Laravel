<?php

namespace App\Http\Controllers;

use App\Models\Mascota;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MascotaController extends Controller
{
    private const ROL_ADMIN = 1;

    private const ROL_VETERINARIO = 2;

    private const ROL_RECEPCIONISTA = 3;

    private const ROL_DUENO = 4;

    public function index(Request $request)
    {
        $termino = trim($request->query('busqueda', ''));
        $rolId = (int) Auth::user()->rol_id;

        $query = Mascota::query()->activas();

        if ($rolId === self::ROL_DUENO) {
            $query->where('dueno_id', Auth::id());
        } elseif ($rolId === self::ROL_VETERINARIO) {
            $query->whereHas('citas', fn ($q) => $q->where('veterinario_id', Auth::id()));
        }

        if ($termino !== '') {
            $query->where(function ($q) use ($termino) {
                $q->where('nombre', 'like', "%{$termino}%")
                    ->orWhere('especie', 'like', "%{$termino}%");
            });
        }

        $mascotas = $query->with('dueno')->orderBy('nombre')->paginate(10)->withQueryString();

        return view('mascotas.index', [
            'mascotas' => $mascotas,
            'termino' => $termino,
        ]);
    }

    public function ver(int $id)
    {
        $mascota = Mascota::with('dueno')->findOrFail($id);
        $this->verificarPropiedad($mascota);

        return view('mascotas.ver', ['mascota' => $mascota]);
    }

    public function mostrarCrear()
    {
        $duenos = $this->puedeElegirDueno() ? Usuario::where('rol_id', self::ROL_DUENO)->orderBy('nombre')->get() : collect();

        return view('mascotas.crear', ['duenos' => $duenos]);
    }

    public function crear(Request $request)
    {
        $reglas = [
            'nombre' => 'required',
            'especie' => 'required',
            'raza' => 'required',
            'fecha_nacimiento' => 'required|date|before_or_equal:today',
            'sexo' => 'required|in:Macho,Hembra',
            'peso' => 'required|numeric|min:0',
        ];

        if ($this->puedeElegirDueno()) {
            $reglas['dueno_id'] = 'required|exists:usuarios,id';
        }

        $datos = $request->validate($reglas);

        $datos['dueno_id'] = $this->puedeElegirDueno() ? $datos['dueno_id'] : Auth::id();
        $datos['activa'] = true;

        Mascota::create($datos);

        return redirect('/mascota')->with('mensaje', 'La mascota fue registrada correctamente.');
    }

    public function mostrarEditar(int $id)
    {
        $mascota = Mascota::findOrFail($id);
        $this->verificarPropiedad($mascota);

        return view('mascotas.editar', ['mascota' => $mascota]);
    }

    public function editar(Request $request, int $id)
    {
        $mascota = Mascota::findOrFail($id);
        $this->verificarPropiedad($mascota);

        $datos = $request->validate([
            'nombre' => 'required',
            'especie' => 'required',
            'raza' => 'required',
            'fecha_nacimiento' => 'required|date|before_or_equal:today',
            'sexo' => 'required|in:Macho,Hembra',
            'peso' => 'required|numeric|min:0',
            'estado_salud' => 'nullable|in:al_dia,pendiente_atencion',
        ]);

        $datos['estado_salud'] = $datos['estado_salud'] ?? $mascota->estado_salud;

        $mascota->update($datos);

        return redirect('/mascota')->with('mensaje', 'Los datos de la mascota han sido actualizados correctamente.');
    }

    public function darDeBaja(int $id)
    {
        $mascota = Mascota::findOrFail($id);
        $this->verificarPropiedad($mascota);

        $mascota->update(['activa' => false]);

        return redirect('/mascota')->with('mensaje', 'La mascota fue dada de baja correctamente.');
    }

    private function puedeElegirDueno(): bool
    {
        return in_array((int) Auth::user()->rol_id, [self::ROL_ADMIN, self::ROL_RECEPCIONISTA]);
    }

    private function verificarPropiedad(Mascota $mascota): void
    {
        if ((int) Auth::user()->rol_id === self::ROL_DUENO && $mascota->dueno_id !== Auth::id()) {
            abort(403, 'No tienes permiso para modificar esta mascota.');
        }
    }
}

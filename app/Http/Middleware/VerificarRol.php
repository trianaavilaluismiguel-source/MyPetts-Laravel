<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificarRol
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (! Auth::check() || ! in_array((string) Auth::user()->rol_id, $roles)) {
            abort(403);
        }

        return $next($request);
    }
}

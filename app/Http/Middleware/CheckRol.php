<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRol
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = auth()->user();

        if (!$user || !in_array($user->rol_id, $this->mapRoles($roles))) {
            abort(403, 'Acceso denegado');
        }

        return $next($request);
    }

    private function mapRoles(array $roles): array
    {
        // Traducción de nombres de rol a IDs, según el seeder:
        $map = [
            'admin' => 1,
            'editor' => 2,
            'usuario' => 3,
        ];

        return array_map(fn($rol) => $map[$rol] ?? 0, $roles);
    }
}

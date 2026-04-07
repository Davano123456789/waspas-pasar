<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Admin can access everything
        if ($user->peran === 'Admin') {
            return $next($request);
        }

        // Check if user has one of the required roles
        if (in_array($user->peran, $roles)) {
            
            // Logika Tambahan: Kepala Pasar hanya bisa input penilaian pasarnya sendiri
            if ($user->peran === 'Kepala Pasar' && $request->routeIs('penilaian.*')) {
                $targetIdPasar = $request->route('id'); // Dari /penilaian/{id}/input
                if ($targetIdPasar && $user->id_pasar != $targetIdPasar) {
                    abort(403, 'Anda tidak memiliki hak akses untuk memberikan penilaian pada pasar lain.');
                }
            }

            return $next($request);
        }

        abort(403, 'Anda tidak memiliki izin (peran) untuk mengakses halaman ini.');
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekAdmin
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        $userRole = auth()->user()->role;

        if (in_array($userRole, $roles, true)) {
            return $next($request);
        }

        if ($userRole === 'admin') {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman pelanggan.');
        }

        if ($userRole === 'pelanggan') {
            return redirect()
                ->route('pelanggan.index')
                ->with('error', 'Anda tidak memiliki akses ke halaman admin.');
        }

        abort(403, 'Role akun tidak valid.');
    }
}
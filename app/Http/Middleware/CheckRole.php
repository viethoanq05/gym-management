<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (! Auth::check() || Auth::user()->role !== $role) {
            abort(403, 'Bạn không có quyền truy cập.');
        }

        return $next($request);
    }
}

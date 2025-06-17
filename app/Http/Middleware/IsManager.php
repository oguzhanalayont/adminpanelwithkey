<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsManager
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->is_manager) {
            abort(403, 'Bu sayfaya erişim yetkiniz yok.');
        }

        return $next($request);
    }
}

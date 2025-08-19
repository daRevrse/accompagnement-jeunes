<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MemoryLimit
{
    public function handle(Request $request, Closure $next)
    {
        // Augmenter la limite mémoire pour les routes admin
        if ($request->is('admin/*')) {
            ini_set('memory_limit', '1024M');
            ini_set('max_execution_time', 300);
        }

        return $next($request);
    }
}

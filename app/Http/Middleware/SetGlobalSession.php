<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SetGlobalSession
{
    public function handle(Request $request, Closure $next)
    {
        // Set session variable only if not already set
        if (!Session::has('branch_code')) {
            Session::put('branch_code', '11111'); // or get from config, DB, etc.
        }

        if (!Session::has('branch_name')) {
            Session::put('branch_name', 'Main Branch');
        }

        return $next($request);
    }
}

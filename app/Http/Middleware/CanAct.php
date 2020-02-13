<?php

namespace App\Http\Middleware;

use Closure;

class CanAct
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if(\Auth::user()->canAct($role)) return $next($request);
        else return redirect('home');
    }
}

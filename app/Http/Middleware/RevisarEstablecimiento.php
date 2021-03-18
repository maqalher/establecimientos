<?php

namespace App\Http\Middleware;

use Closure;

class RevisarEstablecimiento
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // dd('desde m');

        // si el usuario ya tiene registrado un establecimineto
        // if( Auth()->user()->establecimiento) {
        //     return redirect('/establecimiento/edit');
        // }


        return $next($request);
    }
}

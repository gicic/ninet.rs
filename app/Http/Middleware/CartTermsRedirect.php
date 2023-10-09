<?php

namespace App\Http\Middleware;

use Closure;

class CartTermsRedirect
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

        if( ! app('cart')->termsAccepted()) return redirect()->back();

        return $next($request);
    }
}

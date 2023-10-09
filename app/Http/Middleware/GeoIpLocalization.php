<?php

namespace App\Http\Middleware;

use Closure;

class GeoIpLocalization
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
        if( ! session()->has('geo-prefix') && session()->get('geo-prefix') !== 0) {
            $geo_loc = geoip($request->ip());
            if($geo_loc->iso_code == 'RS') {
                session()->put('geo-prefix', 'sr-Latn');
            } else {
                session()->put('geo-prefix', 'en');
            }
            $route = app('laravellocalization')->getLocalizedURL(session()->get('geo-prefix'), null, [], true);
            session()->put('geo-prefix', 0);
            return redirect()->to($route);
        }
        return $next($request);
    }
}

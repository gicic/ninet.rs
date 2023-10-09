<?php

namespace App\Http\Middleware;

use Closure;

class RestrictIpMiddleware
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
        $allowed_ips = env('ALLOWED_IPS');
        $ipsAllow = explode(',',preg_replace('/\s+/', '', $allowed_ips));
//        if(count($ipsAllow) >= 1 )
//        {
            if(!in_array(request()->ip(), $ipsAllow) && env('APP_ENV') === 'staging')
            {
                \Log::warning("Unauthorized access, IP address was => ".request()->ip());
                return response()->json(['Unauthorized!'],400);
            }
//        }
        return $next($request);
    }
}

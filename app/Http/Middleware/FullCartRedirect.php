<?php

namespace App\Http\Middleware;

use Closure;

class FullCartRedirect
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
        $cart = app('cart');
        $locale = app()->getLocale();
        $oldLocale = session()->get('locale');

        if($cart->count() > 0 && $oldLocale !== $locale) {
            $route = app('laravellocalization')->getLocalizedURL($oldLocale, null, [], true);
            return redirect()->to($route);
        }

        return $next($request);
    }
}

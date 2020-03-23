<?php

namespace App\Http\Middleware;

use Closure;

class Currency
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $currency = ($request->hasHeader("x-currency")) ? $request->header('x-currency') : config("currency.default");
        $request->merge(array("currency" => $currency));

        //$request->instance()->query('currency');

        return $next($request);
    }
}
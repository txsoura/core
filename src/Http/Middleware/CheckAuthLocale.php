<?php

namespace Txsoura\Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class CheckAuthLocale
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()) {
            App::setLocale(auth()->user()->lang);
        } else {
            $locale = $request->header('Locale', $request->input('locale'));

            if (!empty($locale)) {
                App::setLocale($locale);
            }
        }

        return $next($request);
    }
}

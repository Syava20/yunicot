<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use App;
use Config;

class LocaleMiddleware
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
        $now_locale = Session::get('locale');

        if(in_array($now_locale, Config::get('app.locales'))){
            $locale = $now_locale;
        }
        else
            $locale = Config::get('app.locale');
        App::setLocale($locale);

        return $next($request);
    }
}

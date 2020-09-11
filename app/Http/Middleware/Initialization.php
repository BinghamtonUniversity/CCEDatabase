<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Response;
use Closure;
use App\SiteConfiguration;

class Initialization
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
        $values = [
            'url' => url('/'),
            'year' => date('Y'),
        ];
        $routes = array_keys(Route::getRoutes()->getRoutesByName());
        foreach($routes as $route) {
            $values[$route] = route($route);
        }

        // Configure and Render Site Config Templates
        $site_config = SiteConfiguration::all();

        foreach($site_config as $config) {
            config(['templates.'.$config->key => $config->value]);
        }
        foreach(config('templates') as $template_name => $template) {
            $m = new \Mustache_Engine;
            config(['templates.'.$template_name=>$m->render($template,$values)]);
        }
        return $next($request);
    }
}

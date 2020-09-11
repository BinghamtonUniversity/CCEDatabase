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
        $site_config = SiteConfiguration::where('key','not like','email%')->get();
        foreach($site_config as $config) {
            $m = new \Mustache_Engine;
            config(['templates.'.$config->key => $m->render($config->value,$values)]);
        }

        // Override  Email Config Templates
        $email_config = SiteConfiguration::where('key','like','email%')->get();
        foreach($email_config as $config) {
            $exploded_key = explode('.',$config->key);
            unset($exploded_key[0]);
            $config->key = implode('.',$exploded_key);
            config(['email_templates.'.$config->key => $config->value]);
        }
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Route;
use Closure;
use App\Models\SiteConfiguration;
use Mustache_Engine;

class Initialization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(\Illuminate\Http\Request $request, Closure $next)
    {
        $values = [
            'url' => url('/'),
            'year' => date('Y'),
        ];

        // Get all named routes
        $routeCollection = Route::getRoutes()->getRoutesByName();

        foreach ($routeCollection as $name => $route) {
            // 1. Skip internal Laravel generated names (e.g., generated::YdFx...)
            if (str_starts_with($name, 'generated::')) {
                continue;
            }

            // 2. Only attempt to generate URLs for routes that have NO parameters.
            // This prevents the UrlGenerationException for routes like listings/{listing}
            if (empty($route->parameterNames())) {
                try {
                    $values[$name] = route($name);
                } catch (\Exception $e) {
                    // Fail-safe to ensure the middleware never crashes the whole app
                    continue;
                }
            }
        }

        // Initialize Mustache once
        $m = new Mustache_Engine;

        // Configure and Render Site Config Templates
        $site_config = SiteConfiguration::where('key', 'not like', 'email%')->get();
        foreach ($site_config as $config) {
            // Render the template using the values (including the safe routes)
            config(['templates.' . $config->key => $m->render($config->value, $values)]);
        }

        // Override Email Config Templates
        $email_config = SiteConfiguration::where('key', 'like', 'email%')->get();
        foreach ($email_config as $config) {
            $exploded_key = explode('.', $config->key);
            unset($exploded_key[0]);
            $new_key = implode('.', $exploded_key);
            config(['email_templates.' . $new_key => $config->value]);
        }

        return $next($request);
    }
}
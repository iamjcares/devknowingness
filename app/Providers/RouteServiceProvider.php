<?php

namespace HelloVideo\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Setting;
use View as View;
use function base_path;

class RouteServiceProvider extends ServiceProvider
{

    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = null;

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  Router  $router
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
        $settings = Setting::first();
        $root_dir = __DIR__ . '/../../public/';

        if (\Cookie::get('theme')) {
            $theme = \Crypt::decrypt(\Cookie::get('theme'));
        } else {
            if ($settings->theme):
                $theme = $settings->theme;
            endif;
        }

        // Add the theme view namespace

        \Config::set('mail.from', ['address' => $settings->system_email, 'name' => $settings->website_name]);

        @include( $root_dir . 'content/themes/' . $theme . '/functions.php');
        View::addNamespace('Theme', $root_dir . 'content/themes/' . $theme);
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));
    }

}

<?php

namespace HelloVideo\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use \Auth as Auth;
use \View as View;
use \Redirect as Redirect;
use Illuminate\Cookie\CookieJar as CookieJar;

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
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
        $settings = \Setting::first();
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
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function($router) {
            require app_path('Http/routes.php');
        });
    }

}

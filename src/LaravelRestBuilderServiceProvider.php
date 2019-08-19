<?php

namespace KhanCode\LaravelRestBuilder;

use Illuminate\Support\ServiceProvider;

class LaravelRestBuilderServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'khancode');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'khancode');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravelrestbuilder.php', 'laravelrestbuilder');

        // Register the service the package provides.
        $this->app->singleton('laravelrestbuilder', function ($app) {
            return new LaravelRestBuilder;
        });

        $this->app->make('KhanCode\LaravelRestBuilder\LaravelRestBuilder');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravelrestbuilder'];
    }
    
    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/laravelrestbuilder.php' => config_path('laravelrestbuilder.php'),
        ], 'laravelrestbuilder.config');

        if( config('laravelrestbuilder.build_active') ) {
            $this->loadMigrationsFrom(__DIR__.'/../src/Migration');
        }

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/khancode'),
        ], 'laravelrestbuilder.views');*/

        // Publishing assets.
        if( config('laravelrestbuilder.build_active') ) {
            $this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/khancode'),
            ], 'laravelrestbuilder.assets');
        }

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/khancode'),
        ], 'laravelrestbuilder.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}

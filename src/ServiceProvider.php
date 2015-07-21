<?php

namespace DraperStudio\SweetFlash;

use Illuminate\Support\ServiceProvider as IlluminateProvider;

class ServiceProvider extends IlluminateProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'sweet');

        $this->publishes([
            __DIR__.'/../views' => base_path('resources/views/vendor/sweet'),
        ], 'views');
    }

    public function register()
    {
        $this->app->singleton('sweet-flash', function () {
            return $this->app->make(Notifier::class);
        });
    }
}

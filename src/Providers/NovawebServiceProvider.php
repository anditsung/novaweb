<?php


namespace Tsung\Novaweb\Providers;

use Anditsung\NovaWebSystemManagement\Http\Middleware\Authorize;
use Illuminate\Support\Facades\Route;
use Laravel\Nova\Nova;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\ServiceProvider;
use Tsung\Novaweb\Commands\Install;
use Tsung\Novaweb\Tools\SystemManagement;

class NovawebServiceProvider extends ServiceProvider
{

    public function boot()
    {
        if($this->app->runningInConsole()) {
            $this->registerPublishing();
        }

        $this->registerResources();
        //$this->registerTools();

        Nova::serving(function (ServingNova $event) {
            Nova::tools($this->tools());
        });
    }

    public function register()
    {
        $this->commands([
            Install::class,
        ]);
    }

    protected function registerResources()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'nova');
    }

    protected function tools()
    {
        return [
            new SystemManagement(),
        ];
    }

    protected function registerPublishing()
    {
        $this->publishes([
            __DIR__ . '/../../public' => public_path('/vendor/novaweb'),
        ], 'novaweb-assets');

        $this->publishes([
            __DIR__.'/../../resources/views' => resource_path('/views'),
        ], 'novaweb-novaviews');
    }
}
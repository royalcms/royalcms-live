<?php

namespace Royalcms\Component\Live;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Royalcms\Component\Live\Paas\Room;

class LiveServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->setUpConfig();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app;

        $app->singleton('live', function($app) {
            return new LiveManager();
        });

    }

    protected function setUpConfig()
    {
        $source = dirname(dirname(dirname(dirname(__DIR__)))) . '/config/live.php';

        $this->publishes([$source => config_path('live.php')], 'config');

        $this->mergeConfigFrom($source, 'live');
    }

}
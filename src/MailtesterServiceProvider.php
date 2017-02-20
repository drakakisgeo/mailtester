<?php

namespace Drakakisgeo\Mailtester;


use Illuminate\Support\ServiceProvider;

class MailtesterServiceProvider extends ServiceProvider
{

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupConfig($this->app);
    }

    /**
     * Setup the config.
     *
     * @param \Illuminate\Contracts\Container\Container $app
     *
     * @return void
     */
    protected function setupConfig(Container $app)
    {
        $source = realpath(__DIR__ . '/../config/mailtester.php');
        $this->publishes([$source => config_path('mailtester.php')]);
        $this->mergeConfigFrom($source, 'mailtester');
    }

    public function register()
    {

    }

}
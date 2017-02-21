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
        $configPath = __DIR__ . '/../config/mailtester.php';
        $this->publishes([$configPath => config_path('mailtester.php')]);
        $this->mergeConfigFrom($configPath, 'mailtester');
    }


    public function register()
    {
        $configPath = __DIR__ . '/../config/mailtester.php';
        $this->mergeConfigFrom($configPath, 'mailtester');
    }
}

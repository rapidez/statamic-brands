<?php

namespace Rapidez\StatamicBrands;

use Rapidez\StatamicBrands\Commands\SyncBrandsCommand;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    public function bootAddon()
    {
        $this->bootCommands()
            ->bootConfig()
            ->bootPublishables();
    }

    public function bootCommands(): self
    {
        $this->commands([
            SyncBrandsCommand::class
        ]);

        return $this;
    }

    public function bootConfig(): self
    {
        $this->mergeConfigFrom(__DIR__.'/../config/statamic-brands.php', 'statamic-brands');

        return $this;
    }

    public function bootPublishables(): self
    {
        $this->publishes([
            __DIR__.'/../resources/blueprints/collections/brands/brands.yaml' => resource_path('blueprints/collections/brands/brands.yaml'),
            __DIR__.'/../resources/content/collections/brands.yaml' => base_path('content/collections/brands.yaml')
        ], 'rapidez-collections');

        $this->publishes([
            __DIR__.'/../config/statamic-brands.php' => config_path('statamic-brands.php'),
        ], 'config');

        return $this;
    }
}

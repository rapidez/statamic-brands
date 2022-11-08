<?php

namespace Rapidez\StatamicBrands;

use Rapidez\Statamic\Repositories\EntryRepository;
use Rapidez\StatamicBrands\Commands\SyncBrandsCommand;
use Statamic\Providers\AddonServiceProvider;
use Statamic\Stache\Repositories\EntryRepository as StatamicEntryRepository;

class ServiceProvider extends AddonServiceProvider
{
    public function bootAddon()
    {
        $this->bootCommands()
            ->bootConfig()
            ->bootRepositories()
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
        $this->mergeConfigFrom(__DIR__.'/../config/brands.php', 'brands');

        return $this;
    }

    public function bootRepositories(): self
    {
        \Statamic::repository(
            StatamicEntryRepository::class,
            EntryRepository::class
        );

        return $this;
    }

    public function bootPublishables(): self
    {
        $this->publishes([
            __DIR__.'/../resources/blueprints/collections/brands/brands.yaml' => resource_path('blueprints/collections/brands/brands.yaml'),
            __DIR__.'/../resources/content/collections/brands.yaml' => base_path('content/collections/brands.yaml')
        ], 'rapidez-collections');

        $this->publishes([
            __DIR__.'/../config/brands.php' => config_path('brands.php'),
        ], 'config');

        return $this;
    }
}

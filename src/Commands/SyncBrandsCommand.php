<?php

namespace Rapidez\StatamicBrands\Commands;

use Illuminate\Console\Command;
use Rapidez\StatamicBrands\Jobs\ImportBrandsJob;

class SyncBrandsCommand extends Command
{
    protected $signature = 'rapidez:statamic:sync:brands';

    protected $description = 'Sync the Magento brand attribute options to Statamic Brands.';

    public function handle(): int
    {
        ImportBrandsJob::dispatch();

        return static::SUCCESS;
    }
}

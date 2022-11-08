<?php

namespace Rapidez\StatamicBrands\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Rapidez\StatamicBrands\Actions\ImportBrands;

class ImportBrandsJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public function handle(ImportBrands $importBrands): void
    {
        $importBrands->import();
    }
}

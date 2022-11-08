<?php

namespace Rapidez\StatamicBrands\Actions;

use Illuminate\Support\Collection;
use Statamic\Facades\Entry;

class DeleteBrands
{
    public function deleteOldBrands(Collection $brandCodes, ?string $storeCode): void
    {
        if ($brandCodes->isEmpty()) {
            return;
        }

        $deletedBrands = Entry::whereCollection('brands')->where('locale', $storeCode)->filter(fn ($deletedBrand) => !$brandCodes->contains($deletedBrand->get('brand_code')));
        $deletedBrands->each(fn ($deletedBrand) => $deletedBrand->delete());
    }
}

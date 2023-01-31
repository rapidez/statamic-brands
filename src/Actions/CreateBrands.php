<?php

namespace Rapidez\StatamicBrands\Actions;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Statamic\Facades\Entry;

class CreateBrands
{
    public function create(Collection $brands, string $storeCode): Collection
    {
        if ($brands->isEmpty()) {
            return new Collection();
        }

        return $brands->filter(fn ($brand) => !blank($brand->name) && !blank($brand->brand_code))
            ->map(fn ($brand) => [
                'title' => $brand->title,
                'slug' => $brand->brand_code,
                'brand_code' => $brand->brand_code,
                'path' => $brand->brand_code
            ])
            ->each(fn ($brand) => Entry::updateOrCreate($brand, 'brands', 'brand_code', $storeCode));
    }
}

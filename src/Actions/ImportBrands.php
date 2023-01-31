<?php

namespace Rapidez\StatamicBrands\Actions;

use Rapidez\StatamicBrands\Events\BrandsImportedEvent;
use Statamic\Facades\Site;

class ImportBrands
{
    public function __construct(
        public CreateBrands $createBrands,
        public DeleteBrands $deleteBrands,
        protected int $chunkSize = 20
    ) {
    }

    public function import(): void
    {
        $attributeModel = config('rapidez.models.attribute');
        $attributeModelInstance = new $attributeModel;

        foreach(Site::all() as $site) {
            $siteAttributes = $site->attributes();
            if (!isset($siteAttributes['magento_store_id'])) {
                continue;
            }

            config()->set('rapidez.store', $siteAttributes['magento_store_id']);

            $brandCodes = collect();
            $brandQuery = $attributeModel::select([
                $attributeModelInstance->qualifyColumn('attribute_code'),
                'eav_attribute_option.sort_order',
                'eav_attribute_option_value.value as title',
                'brand_code.value as brand_code'
            ])
                ->where('attribute_code', config('statamic-brands.brand_attribute_code'))
                ->join('eav_attribute_option', 'eav_attribute_option.attribute_id', 'eav_attribute.attribute_id')
                ->join('eav_attribute_option_value', function ($join) {
                    $join->on('eav_attribute_option_value.option_id', 'eav_attribute_option.option_id')
                         ->where('eav_attribute_option_value.store_id', config('rapidez.store'));
                })
                ->join('eav_attribute_option_value as brand_code', function ($join) {
                    $join->on('brand_code.option_id', 'eav_attribute_option.option_id')
                         ->where('brand_code.store_id', 0);
                });

            $brandQuery->chunk($this->chunkSize, function ($brands) use ($site, &$brandCodes) {
                $brands = $this->createBrands->create($brands, $site->handle());
                $brandCodes = $brandCodes->merge($brands->map(fn ($brand) => $brand['brand_code']));
            });

            $this->deleteBrands->deleteOldBrands($brandCodes, $site->handle());
        }

        BrandsImportedEvent::dispatch();
    }
}

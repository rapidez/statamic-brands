
# Rapidez Statamic Brands

> This is a Statamic add-on used to import brands from Magento as a Statamic collection, so that the brand information can be enriched in Statamic.

## Features
- Export Brands from Magento's brand attribute options and import into Brands collection
- Enrich brands with more information
- Multistore support

## How to Install
### Install using Composer
``` bash
composer require rapidez/statamic-brands
```

### Publish the YAML settings
``` bash
php artisan vendor:publish --provider="Rapidez\StatamicBrands\ServiceProvider"
```

### Brand attribute code (optional)
The default attribute code used for brands is `brand`, but it is also possible that another attribute is used for this. You can change this by adding the variable `BRAND_ATTRIBUTE_CODE` to the environment variables (`.env`). 
For example:
``` .env
BRAND_ATTRIBUTE_CODE="manufacturer"
```

### Multisite
When configuring your multisite for Statamic, it is important to add the stores to the sites section in the published file `content/collections/brands.yaml`, for example:

```yaml
title: Brands
sites:
  - default
  - rapidez_nl
  - rapidez_uk
propagate: false
template: default
layout: layout
revisions: false
sort_dir: asc
date_behavior:
  past: public
  future: private
```

## How to Use
### Commands
Run the following command to run the brand import:
``` bash
php artisan rapidez:statamic:sync:brands
```

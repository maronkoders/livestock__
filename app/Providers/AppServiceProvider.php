<?php

namespace App\Providers;

use App\Company;
use App\CompanyRedirectCount;
use App\Industry;
use App\Observers\CompanyObserver;
use App\Observers\CompanyRedirectCountObserver;
use App\Observers\IndustryObserver;
use App\Observers\ProductCategoryObserver;
use App\Observers\ProductObserver;
use App\Product;
use App\ProductCategory;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\UrlGenerator;

class AppServiceProvider extends ServiceProvider
{

    public function register()
    {
        //
    }

    public function boot(UrlGenerator $url)
    {
        // if (env('APP_ENV') !== 'test') {
        //     $url->forceScheme('https');
        // }
        
        CompanyRedirectCount::observe(CompanyRedirectCountObserver::class);
        Industry::observe(IndustryObserver::class);
        Company::observe(CompanyObserver::class);
        ProductCategory::observe(ProductCategoryObserver::class);
        // Product::observe(ProductObserver::class);
    }
}

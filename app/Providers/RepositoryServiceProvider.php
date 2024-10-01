<?php

namespace App\Providers;

use App\Repositories\InterfaceRepositories\HomeRepositoryInterface;
use App\Repositories\InterfaceRepositories\ProfileRepositoryInterface;
use App\Repositories\Shopify\HomeRepository;
use App\Repositories\Shopify\ProfileRepository;
use App\Services\ServiceInterface\HomeServiceInterface;
use App\Services\ServiceInterface\ProfileServiceInterface;
use App\Services\Shopify\HomeService;
use App\Services\Shopify\ProfileService;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(HomeServiceInterface::class, HomeService::class);
        $this->app->bind(HomeRepositoryInterface::class, HomeRepository::class);
        $this->app->bind(ProfileServiceInterface::class, ProfileService::class);
        $this->app->bind(ProfileRepositoryInterface::class, ProfileRepository::class);
        
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        
    }
}

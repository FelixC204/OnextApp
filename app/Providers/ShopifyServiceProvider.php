<?php

namespace App\Providers;

use Shopify\Context;
use Illuminate\Support\ServiceProvider;
use Shopify\Auth\FileSessionStorage;

class ShopifyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $apiKey = env('SHOPIFY_API_KEY');
        $apiSecretKey = env('SHOPIFY_API_SECRET'); // Đảm bảo là 'SHOPIFY_API_SECRET'

        Context::initialize(
            apiKey: $apiKey,
            apiSecretKey: $apiSecretKey,
            scopes: env('SCOPES'), // Cũng nên sử dụng tên biến này
            hostName: env('SHOPIFY_APP_HOST_NAME'), // Cũng nên sử dụng tên biến này
            sessionStorage: new FileSessionStorage(storage_path('framework/sessions')),
            apiVersion: '2024-07',
            isEmbeddedApp: true,
            isPrivateApp: false,
        );
    }


    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

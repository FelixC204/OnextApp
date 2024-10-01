<?php

namespace App\Services\Shopify;

use App\Http\Controllers\Shopify\AuthController;
use App\Models\User;
use App\Repositories\InterfaceRepositories\HomeRepositoryInterface;
use App\Services\ServiceInterface\HomeServiceInterface;
use Shopify\Clients\Rest;

class HomeService implements HomeServiceInterface
{
    protected $HomeRepository;
    public function __construct(HomeRepositoryInterface $HomeRepository)
    {
        $this->HomeRepository = $HomeRepository;
    }


    public function getAccesssToken($shop_domain)
    {
        $shop =  $this->HomeRepository->getAccesssToken($shop_domain);
        return $shop;
    }
}

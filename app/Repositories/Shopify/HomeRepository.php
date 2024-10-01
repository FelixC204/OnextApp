<?php

namespace App\Repositories\Shopify;

use App\Repositories\BaseRepository;
use App\Repositories\InterfaceRepositories\HomeRepositoryInterface;
use App\Models\User;

class HomeRepository extends BaseRepository implements HomeRepositoryInterface
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getAccesssToken($shop_domain)
    {
        $shop =  $this->model->where('store_url', $shop_domain)->first();

        if ($shop) {
            return $shop->access_token; 
        }

        return null; 
    }
}

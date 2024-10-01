<?php

namespace App\Repositories\Shopify;

use App\Repositories\BaseRepository;
use App\Repositories\InterfaceRepositories\ProfileRepositoryInterface;
use App\Models\User;

class ProfileRepository extends BaseRepository implements ProfileRepositoryInterface
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getStore($shop_domain)
    {
        $shop =  $this->model->where('store_url', $shop_domain)->first();

        if ($shop) {
            return $shop; 
        }

        return null; 
    }
}

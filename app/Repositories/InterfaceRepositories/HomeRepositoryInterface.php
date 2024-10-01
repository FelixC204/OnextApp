<?php 

namespace App\Repositories\InterfaceRepositories;

use App\Repositories\InterfaceRepositories\BaseRepositoryInterface;

interface HomeRepositoryInterface extends BaseRepositoryInterface
{
    public function getAccesssToken($shop_domain);
}
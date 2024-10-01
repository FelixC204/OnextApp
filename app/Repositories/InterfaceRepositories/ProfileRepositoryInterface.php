<?php

namespace App\Repositories\InterfaceRepositories;
use App\Repositories\InterfaceRepositories\BaseRepositoryInterface;

interface ProfileRepositoryInterface extends BaseRepositoryInterface
{
    public function getStore($shop_domain);
}

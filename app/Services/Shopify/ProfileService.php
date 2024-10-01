<?php

namespace App\Services\Shopify;

use App\Repositories\InterfaceRepositories\ProfileRepositoryInterface;
use App\Services\ServiceInterface\ProfileServiceInterface;

class ProfileService implements ProfileServiceInterface
{

    protected $ProfileRepository;
    public function __construct(ProfileRepositoryInterface $ProfileRepository)
    {
        $this->ProfileRepository = $ProfileRepository;
    }

    public function getProfile($shop_domain)
    {
        $shop =  $this->ProfileRepository->getStore($shop_domain);
        $data = [
            "shop_owner" => $shop->name,
            "shop_domain" => $shop->store_url,
            "shop_email" => $shop->email,
        ];
        return $data;
    }

    public function updateProfile($shop_domain, $data) {}
    public function deleteProfile($shop_domain) {}
}

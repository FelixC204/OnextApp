<?php

namespace App\Services\ServiceInterface;

interface ProfileServiceInterface
{
    public function getProfile($shop_domain);
    public function updateProfile($shop_domain, $data);
    public function deleteProfile($shop_domain);   
}

<?php

namespace App\Http\Controllers\Shopify;

use App\Http\Controllers\Controller;
use App\Services\Shopify\ProfileService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    protected $profileService;
    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function getProfile(Request $request)
    {
        $shop_domain = $request->get('shop_domain');
        $data = $this->profileService->getProfile($shop_domain);
        return response()->json($data);
    }
}

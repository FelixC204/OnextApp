<?php

namespace App\Http\Controllers\Shopify;

use App\Http\Controllers\Controller;
use App\Services\ServiceInterface\HomeServiceInterface;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $homeService;
    public function __construct(HomeServiceInterface $homeService)
    {
        $this->homeService = $homeService;
    }
    public function homeIndex(){
       
    }
}

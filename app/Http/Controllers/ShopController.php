<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\Shop;

class ShopController extends Controller
{
    public function index() {
        $shops = Area::find(1)->shops;
        
        $area = Shop::find(1)->area;
        
        $routes = Shop::find(1)->routes()->get();

        dd($shops, $area, $routes);
    }
}

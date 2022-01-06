<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Campaign\Campaigns;
use App\Models\User\SocialProviders;
use Illuminate\Support\Facades\Auth;
use App\Models\Shopify\Shopify;
use App\Models\Shop;

class OrderController extends Controller
{
    

    /**
     * Show the all orders.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $shops = Shop::all();
        return view('orders.index', compact('shops'));
    }

    public function data(Request $request,Shop $shop)
    {
        $shopify = new Shopify();
        $shopifyUser = (new SocialProviders)->getShopifyById($shop->user_id);
        $list = $shopify->getAllOrders($shopifyUser, $request->token);

        return view('orders.list', [
            'list'      => $list['data'],
            'nextId'    => $list['next'],
            'prevId'    => $list['prev'],
        ]);
    }
}

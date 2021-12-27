<?php

namespace App\Http\Controllers;

use App\Models\Campaign\CampaignAudienceSizes;
use App\Models\Campaign\DesignHuddle;
use App\Models\Shop;
use App\Models\Shopify\Orders;
use App\Models\Campaign\Campaigns;
use App\Models\User\SocialProviders;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Dashboard\PrepareAnalyticsDataRequest;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $userId;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            return $next($request);
        });

    }

    public function index()
    {
        $shop = new Shop();
        $available = $shop->shopsWithoutCampaigns($this->userId);
        $audienceSizes = CampaignAudienceSizes::all();
        $shopifyUser = (new SocialProviders)->getShopifyById(Auth::id());
        $DH = (new DesignHuddle)->firstOrCreate($shopifyUser);

        return view('getting-started', [
            'availableShops' => $available,
            'audienceSizes' => $audienceSizes,
            'userShop' => $shopifyUser->nickname,
            'userToken' => $DH->access_token,
        ]);
    }

    public function analyticsDashboard()
    {
        $campaigns = Campaigns::all();
        return view('analytics-dashboard', [
            'campaigns' =>  $campaigns,
        ]);
    }

    public function prepareAnalyticsData(PrepareAnalyticsDataRequest $request){
        $input = $request->all();
        // dd(auth()->user());
        $visitor_count = Orders::count('browser_ip');
        $revenue_count = Orders::count('order_total');
        $revenue_total = Orders::sum('order_total');

        // $total_orders;
        $preparedData = [
            "site_visitors" => [
                [ "count" => $visitor_count ],
                [ "data" => [25, 66, 41, 89, 63, 25, 44, 12, 36, 9, 54] ],
            ],
            "add_to_carts" => [
                [ "count" => "10258" ],
                [ "data" => [25, 66, 41, 89, 63, 25, 44, 12, 36, 9, 54] ],
            ],
            "abandon_checkout" => [
                [ "count" => number_format($revenue_count, 2) ],
                [ "data" => [25, 66, 41, 89, 63, 25, 44, 12, 36, 9, 54] ],
            ],
            "you_made" => [
                ["revenue"  => number_format($revenue_total,2)],
                ["new_orders"   => 120146],
                ["returns"  => 5.2],
            ],
            "revenue_chart" => [
                [ "value"   => 220840 ],
                [
                    "data"  => [
                        ["x"    => "08/01/2020", "y" => 20000],
                        ["x"    => "09/01/2020", "y" => 15000],
                    ],
                ],
            ],
            "new_orders_chart" => [
                [ "value"   => 3863 ],
                [
                    "data"  => [
                        ["x"    => "08/01/2020", "y" => 20000],
                        ["x"    => "09/01/2020", "y" => 15000 ],
                    ],
                ],
            ],
            "returns_chart" => [
                [ "value"   =>  3.4  ],
                [
                    "data"  => [
                        ["x"    => "08/01/2020", "y" => 2],
                        ["x"    => "09/01/2020", "y" => 3],
                    ],
                ],
            ],
            "total_cost_chart" => [
                [ "value"   =>  1125  ],
                [
                    "data"  => [
                        ["x"    => "08/01/2020", "y" => 1000],
                        ["x"    => "09/01/2020", "y" => 900],
                    ],
                ],
            ],
            "customer_aquisition_chart" => [
                [ "value"   =>  30  ],
                [
                    "data"  => [
                        ["x"    => "08/01/2020", "y" => 25],
                        ["x"    => "09/01/2020", "y" => 36],
                    ],
                ],
            ],
            "conversion_rate_chart" => [
                [ "value"   =>  4.72  ],
                [
                    "data"  => [
                        ["x"    => "08/01/2020", "y" => 8],
                        ["x"    => "09/01/2020", "y" => 6],
                    ],
                ],
            ],
        ];

        return response()->json($preparedData);
    }

    public function account()
    {
        return view('account', [
        ]);
    }
    public function manualCampaigns()
    {
        return view('manual-campaigns', [
        ]);
    }
}

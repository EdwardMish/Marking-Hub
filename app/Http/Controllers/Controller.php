<?php

namespace App\Http\Controllers;

use App\Models\Campaign\CampaignAudienceSizes;
use App\Models\Campaign\DesignHuddle;
use App\Models\Shop;
use App\Models\Shopify\Orders;
use App\Models\Shopify\Shopify;
use App\Models\Visitor;
use App\Models\Campaign\Campaigns;
use App\Models\User\SocialProviders;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Dashboard\PrepareAnalyticsDataRequest;
use App\Http\Requests\GetQRCodeRequest;
use QrCode;

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

    public function getQRCode(GetQRCodeRequest $request)
    {
        if($request->url) {
            return QrCode::generate($request->url);
        }
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

        $startEndDate = [$input['start_date'], $input['end_date']];
        $user = auth()->user();
        $shop = Shop::where('user_id',$user->id)->first();
        
        $shopWhere = ['shop_id' => $shop->id,];
        
        // visitor
        $visitorQuery = Visitor::where($shopWhere + ['type' => 'activity'])->whereBetween('timestamp',$startEndDate);
        $visitor_count = $visitorQuery->sum('counter');
        $visitor_daywise_count = $visitorQuery->orderBy('timestamp','asc')->select('counter')->limit(5)->get()->pluck('counter')->toArray();

        // add to cart
        $cartQuery = Visitor::where($shopWhere + ['type' => 'add_to_cart'])->whereBetween('timestamp',$startEndDate);
        $cart_count = $cartQuery->sum('counter');
        $cart_daywise_count = $cartQuery->orderBy('timestamp','asc')->select('counter')->limit(5)->get()->pluck('counter')->toArray();

        // checkout 
        $orderQuery = Orders::where($shopWhere)->whereNotNull('browser_ip')->whereBetween('order_date',$startEndDate);
        $revenue_count = $orderQuery->count('order_total');
        $revenue_daywise_count = $orderQuery->groupBy(\DB::raw("DATE(`order_date`)"))->select(\DB::raw('COUNT(`browser_ip`) as counter'))->get()->pluck('counter')->toArray();

        // revenue_chart
        $revenue_total = $orderQuery->sum('order_total');
        $revenue_daywise_total = $orderQuery->groupBy(\DB::raw("DATE(`order_date`)"))->orderBy('x','asc')->select(\DB::raw('ROUND(SUM(`order_total`)) as y'), \DB::raw('DATE(`order_date`) as x'))->get()->toArray();


        // new_orders_chart
        $neworderChartWhere = $shopWhere + [];
        $neworder_total = Orders::where($neworderChartWhere)->whereNotNull('browser_ip')->whereBetween('order_date',$startEndDate)->count('order_total');
        $neworder_daywise_total = Orders::where($neworderChartWhere)->whereNotNull('browser_ip')->whereBetween('order_date',$startEndDate)->groupBy(\DB::raw("DATE(`order_date`)"))->orderBy('x','asc')->select(\DB::raw('COUNT(`order_total`) as y'), \DB::raw('DATE(`order_date`) as x'))->get()->toArray();
        

        // dd($revenue_daywise_total);
        // $total_orders;
        $preparedData = [
            "site_visitors" => [
                [ "count" => $visitor_count ],
                [ "data" => $visitor_daywise_count ],
            ],
            "add_to_carts" => [
                [ "count" => $cart_count ],
                [ "data" => $cart_daywise_count ],
            ],
            "abandon_checkout" => [
                [ "count" => $revenue_count ],
                [ "data" => $revenue_daywise_count ],
            ],
            "you_made" => [
                ["revenue"  => number_format($revenue_total,2)],
                ["new_orders"   => $neworder_total],
                ["returns"  => 5.2],
            ],
            "revenue_chart" => [
                [ "value"   => number_format($revenue_total,2) ],
                [
                    "data"  => $revenue_daywise_total,
                ],
            ],
            "new_orders_chart" => [
                [ "value"   => $neworder_total ],
                [
                    "data"  => $neworder_daywise_total,
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

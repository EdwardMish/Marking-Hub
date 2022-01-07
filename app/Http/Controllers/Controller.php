<?php

namespace App\Http\Controllers;

use App\Models\Campaign\CampaignAudienceSizes;
use App\Models\Campaign\DesignHuddle;
use App\Models\Shop;
<<<<<<< HEAD
use App\Models\Shopify\Orders;
use App\Models\Shopify\Shopify;
use App\Models\Visitor;
use App\Models\VisitorIp;
use App\Models\Campaign\Campaigns;
use App\Models\Campaign\CampaignTargetHistory;
=======
>>>>>>> new-design
use App\Models\User\SocialProviders;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
<<<<<<< HEAD
use App\Http\Requests\Dashboard\PrepareAnalyticsDataRequest;
use App\Http\Requests\GetQRCodeRequest;
use QrCode;
use App\Models\Analytics\Dynamo;
=======
use App\Http\Requests\GetQRCodeRequest;
use QrCode;
>>>>>>> new-design

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $userId;

    public function __construct()
<<<<<<< HEAD
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            return $next($request);
        });

=======
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
        return view('analytics-dashboard', [
        ]);
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
>>>>>>> new-design
    }
}

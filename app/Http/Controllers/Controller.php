<?php

namespace App\Http\Controllers;

use App\Models\Campaign\CampaignAudienceSizes;
use App\Models\Campaign\DesignHuddle;
use App\Models\Shop;
use App\Models\User\SocialProviders;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
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
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Campaign\Campaigns;
use App\Models\Campaign\DesignHuddle;
use App\Models\User\SocialProviders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CampaignController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

//    public function designPostcard()
//    {
//        $shopifyUser = (new SocialProviders)->getShopifyById(Auth::id());
//        $DH = (new DesignHuddle)->firstOrCreate($shopifyUser);
//
//        return view('campaign.design', [
//            'userShop' => 'https://'.$shopifyUser->nickname,
//            'userToken' => $DH->access_token
//        ]);
//    }

    public function designPostcard(Request $request)
    {
        $projectId = $request->route('project_id');
        $shopifyUser = (new SocialProviders)->getShopifyById(Auth::id());
        $DesignHuddle = new DesignHuddle();
        $DH = $DesignHuddle->firstOrCreate($shopifyUser);

        return view('campaign.design-postcard', [
            'userShop' => 'https://'.$shopifyUser->nickname,
            'userToken' => $DH->access_token,
            'projectId' => $projectId
        ]);
    }

    public function selectPostcard()
    {
        $shopifyUser = (new SocialProviders)->getShopifyById(Auth::id());
        $DH = (new DesignHuddle)->firstOrCreate($shopifyUser);
        return view('campaign.select-postcard', [
            'userShop' => 'https://'.$shopifyUser->nickname,
            'userToken' => $DH->access_token
        ]);
    }

    public function createCampaign(Request $request)
    {
        $projectId = $request->route('project_id');
        $userId = Auth::id();
        $access_token = SocialProviders::where(['provider_id' => 2, 'user_id' => $userId])->first()->access_token;

        $thumbnailUrl = (new DesignHuddle())->getThumbnail($access_token, $projectId);
        Campaigns::create([
            'user_id' => $userId,
            'project_id' => $projectId,
            'thumbnail_url' => $thumbnailUrl,
            'state' => 1
            //Hardcoded State, could call DB and retrieve value however this is part of migration so I can be reasonably certain this value is correct
        ]);

        return redirect()->route('selectAudience', ['project_id' => $projectId]);
    }

    public function startCampaign(Request $request)
    {
        $projectId = $request->route('project_id');
        $userId = Auth::id();
        $access_token = SocialProviders::where(['provider_id' => 2, 'user_id' => $userId])->first()->access_token;

        $thumbnailUrl = (new DesignHuddle())->getThumbnail($access_token, $projectId);
        Campaigns::create([
            'user_id' => $userId,
            'project_id' => $projectId,
            'thumbnail_url' => $thumbnailUrl,
            'state' => 1
            //Hardcoded State, could call DB and retrieve value however this is part of migration so I can be reasonably certain this value is correct
        ]);
        //@todo: Send to 3rd Party

        return redirect()->route('viewCampaigns');
    }

    public function selectAudience(Request $request)
    {
        $projectId = $request->route('project_id');
        $shopifyUser = (new SocialProviders)->getShopifyById(Auth::id());
        $DH = (new DesignHuddle)->firstOrCreate($shopifyUser);
        return view('campaign.select-audience', [
            'userShop' => 'https://'.$shopifyUser->nickname,
            'userToken' => $DH->access_token,
            'projectId' => $projectId
        ]);
    }

    public function viewCampaigns(Request $request)
    {
        $shopifyUser = (new SocialProviders)->getShopifyById(Auth::id());
        $campaigns = Campaigns::all();
        return view('campaign.view', [
            'userShop' => 'https://'.$shopifyUser->nickname,
            'campaigns' => $campaigns
        ]);

    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Campaign\CampaignAudienceSizes;
use App\Models\Campaign\CampaignCron;
use App\Models\Campaign\Campaigns;
use App\Models\Campaign\CampaignsState;
use App\Models\Campaign\DesignHuddle;
use App\Models\User\SocialProviders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
            'state_id' => 1
            //Hardcoded State, could call DB and retrieve value however this is part of migration so I can be reasonably certain this value is correct
        ]);

        return redirect()->route('selectAudience', ['project_id' => $projectId]);
    }

    public function startCampaign(Request $request)
    {

        // Could add validator against audience_states but there's no real need for the extra call as only malicious
        // users could break this, and they can only break their own campaigns, why would they do this.
        $rules = [
            'audience' => 'required|int',
        ];

        $validator = Validator::make($request->all(), $rules);

        $projectId = $request->route('project_id');
        $userId = Auth::id();
        $campaign = Campaigns::where(['user_id' => $userId, 'project_id' => $projectId])->first();
        $campaignState = CampaignsState::where(['name' => 'Active'])->first();

        if ($validator->validated()) {
            //using request here should be fine given it was just validated
            $campaign->audience_size_id = $request->get('audience');
        }

        if ($request->get('submit') == 'start') {
            //Check to see if there is already an active campaign
            $activeCampaigns = Campaigns::where(['user_id' => $userId, 'state_id' => $campaignState->id])->get();
            if ($activeCampaigns->count() == 0) {
                $campaign->state_id = $campaignState->id;
            } else {
                $validator->errors()->add('campaign_id',
                    'There is already an active campaign.  You can only have one active campaign at a time, your campaign was saved, however, it was not activated.');
            }
        }

        $campaign->save();

        return redirect()->route('viewCampaigns')->withErrors($validator);
    }

    public function selectAudience(Request $request)
    {
        $projectId = $request->route('project_id');
        $shopifyUser = (new SocialProviders)->getShopifyById(Auth::id());
        $DH = (new DesignHuddle)->firstOrCreate($shopifyUser);
        $audienceSizes = CampaignAudienceSizes::all();
        return view('campaign.select-audience', [
            'userShop' => 'https://'.$shopifyUser->nickname,
            'userToken' => $DH->access_token,
            'projectId' => $projectId,
            'audienceSizes' => $audienceSizes
        ]);
    }

    public function viewCampaigns(Request $request)
    {
        $shopifyUser = (new SocialProviders)->getShopifyById(Auth::id());
        $campaigns = (new Campaigns)->getAllCampaignsReadable(Auth::id());
        (new CampaignCron())->queueCampaigns();
        return view('campaign.view', [
            'userShop' => 'https://'.$shopifyUser->nickname,
            'campaigns' => $campaigns
        ]);

    }
}

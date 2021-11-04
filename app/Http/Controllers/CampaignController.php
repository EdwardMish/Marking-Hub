<?php

namespace App\Http\Controllers;

use App\Models\Campaign\CampaignAudienceSizes;
use App\Models\Campaign\CampaignCron;
use App\Models\Campaign\Campaigns;
use App\Models\Campaign\CampaignsState;
use App\Models\Campaign\DesignHuddle;
use App\Models\Shopify\Shopify;
use App\Models\User\SocialProviders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CampaignController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth');
    }

//    public function designPostcard()
//    {
//        $shopifyUser = (new SocialProviders)->getShopifyById(Auth::id());
//        $DH = (new DesignHuddle)->firstOrCreate($shopifyUser);
//
//        return view('campaign.design', [
//            'userShop' => $shopifyUser->nickname,
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
            'userShop' => $shopifyUser->nickname,
            'userToken' => $DH->access_token,
            'projectId' => $projectId
        ]);
    }

    public function getThumbnail(Request $request)
    {
        $projectId = $request->get('project_id');
        $rules = [
            'project_id' => 'required|alpha_num',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->errors()->count() > 0) {
            $message = count($validator->errors()->all()) > 1 ? implode($validator->errors()->all(),
                    ' and ').'.' : $validator->errors()->all()[0].'.';
            return response()->json([
                'status' => 'error',
                'messages' => $message
            ], 400);
        }

        $userId = Auth::id();
        $access_token = SocialProviders::where(['provider_id' => 2, 'user_id' => $userId])->first()->access_token;
        $thumbnailUrl = (new DesignHuddle())->getThumbnail($access_token, $projectId);

        return response()->json([
            'thumbnail_url' => $thumbnailUrl
        ]);
    }

    public function selectPostcard()
    {
        $shopifyUser = (new SocialProviders)->getShopifyById(Auth::id());
        $DH = (new DesignHuddle)->firstOrCreate($shopifyUser);
        return view('campaign.select-postcard', [
            'userShop' => $shopifyUser->nickname,
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
            'project_id' => 'required|alpha_num',
            'discount_type' => ['required', Rule::in(['1', '2'])],
            'discount_amount' => ['required', 'regex:/^\$?([0-9]+)%?$/'],
            'discount_prefix' => ['required', 'string'],
            'thumbnail_url' => ['required', 'url']
        ];

        $validator = Validator::make($request->all(), $rules, $messages = [
            'thumbnail_url.required' => 'You must save your postcard design before proceeding',
            'project_id.required' => 'You must select a postcard template before proceeding',
        ]);

        if ($validator->errors()->count() > 0) {
            return redirect()->route('viewCampaigns')->withErrors($validator);
        }

        $params = $validator->validate();
        $projectId = $params['project_id'];
        $userId = Auth::id();
        $campaign = Campaigns::firstOrNew(['user_id' => $userId, 'project_id' => $projectId]);
        $campaignState = CampaignsState::where(['name' => 'Active'])->first();

        $campaign->audience_size_id = $params['audience'];


        //Check to see if there is already an active campaign
        $activeCampaigns = Campaigns::where(['user_id' => $userId, 'state_id' => $campaignState->id])->get();
        if ($activeCampaigns->count() == 0) {
            $campaign->state_id = $campaignState->id;
        } else {
            $validator->errors()->add('campaign_id',
                'There is already an active campaign.  You can only have one active campaign at a time, your campaign was saved, however, it was not activated.');
        }

        $shopify = new Shopify();
        $social = (new SocialProviders)->getShopifyById(Auth::id());
        $priceRule = $shopify->submitPriceRule($social, $params);
        //Save priceRuleId in to Table required for DiscountCode
        $campaign->discount_amount = floatval(preg_replace("/[^0-9.]/", "", $params['discount_amount']));
        $campaign->discount_price_rule_id = $priceRule->price_rule->id;
        $campaign->discount_prefix = $params['discount_prefix'];
        $campaign->discount_type = $params['discount_type'];
        $campaign->thumbnail_url = $params['thumbnail_url'];
        $campaign->save();

        return redirect()->route('viewCampaigns')->withErrors($validator);
    }

    public function addOffer(Request $request)
    {
        $rules = [
            'discount_type' => ['required', Rule::in(['1', '2'])],
            'discount_amount' => ['required', 'regex:/^\$?([0-9]+)%?$/'],
            'discount_prefix' => ['required', 'string']
        ];

        $validator = Validator::make($request->all(), $rules);

        return $validator;

    }

    public function selectAudience(Request $request)
    {
        $projectId = $request->route('project_id');
        $shopifyUser = (new SocialProviders)->getShopifyById(Auth::id());
        $DH = (new DesignHuddle)->firstOrCreate($shopifyUser);
        $audienceSizes = CampaignAudienceSizes::all();
        return view('campaign.select-audience', [
            'userShop' => $shopifyUser->nickname,
            'userToken' => $DH->access_token,
            'projectId' => $projectId,
            'audienceSizes' => $audienceSizes
        ]);
    }

    public function viewCampaigns(Request $request)
    {
        $shopifyUser = (new SocialProviders)->getShopifyById(Auth::id());
        $campaigns = (new Campaigns)->getAllCampaignsReadable(Auth::id());
        $audienceSizes = CampaignAudienceSizes::all();

        if ($campaigns->count() == 0) {
            $DH = (new DesignHuddle)->firstOrCreate($shopifyUser);
            return view('campaign.create', [
                'audienceSizes' => $audienceSizes,
                'userShop' => $shopifyUser->nickname,
                'userToken' => $DH->access_token
            ]);
        } else {


            return view('dashboard', [
                'userShop' => $shopifyUser->nickname,
                'campaigns' => $campaigns
            ]);
        }
    }
}

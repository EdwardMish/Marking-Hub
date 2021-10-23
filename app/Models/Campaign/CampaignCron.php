<?php

namespace App\Models\Campaign;

use App\Events\CampaignProcessed;
use App\Models\Analytics\Dynamo;
use App\Models\Shopify;
use App\Models\User\SocialProviders;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class CampaignCron
{

    static public function queueCampaigns()
    {

        // Get List of Active Campaigns
        $campaigns = Campaigns::where(['state_id' => 10])->get();
        $dynamo = new Dynamo();
        $social = new SocialProviders();
        $orders = new Shopify\Orders();
        $history = new CampaignTargetHistory();

        foreach ($campaigns as $campaign) {
            //Can set NextRun now, if there is overlap it's okay as there is no non-breaking code
            $nextRun = now();
            //Search DynamoDB
            unset($exemptVisitors);
            unset($current);
            $exemptVisitors = [];
            $current = [];

            //Get Orders since last campaign
            $shopifyUser = $social->where(['user_id' => $campaign->user_id, 'provider_id' => 1])->first();
            $orders->upsertOrder($shopifyUser, $campaign->last_ran);

            //Check against Shopify Recent Purchases
            $exemptOrders = $orders->getExemptUsers($campaign->user_id);
            //Check against Previous Mailings
            $exemptHistory = $history->getExemptUsers($campaign->id);
            $exemptVisitors = array_merge($exemptOrders, $exemptHistory);

            $lastRan = ($campaign->last_ran === null) ? 0 : \DateTime::createFromFormat('Y-m-d H:i:s',$campaign->last_ran)->getTimestamp();
            $visitors = $dynamo->getVisitByShop($campaign->user_id, $lastRan);

            $campaignHistory = CampaignHistory::create([
                'campaign_id' => $campaign->id,
                'state_id' => 1
            ]);
            foreach ($visitors as $visit) {

                //Check Current Send
                if (key_exists($visit['ip'], $current))
                    continue;

                //@ToDo: Put this check back in
//                if($visit['audience_ip'] != $campaign->audience_size_id)
//                    continue;

                //Check for Matching Records
                if (array_key_exists($visit['ip'], $exemptVisitors))
                    continue;

                //Create CampaignHistory Record
                CampaignTargetHistory::create([
                    'id' => Uuid::uuid4(),
                    'campaign_id' => $campaign->id,
                    'campaign_history_id' => $campaignHistory->id,
                    'browser_ip' => $visit['ip']
                ]);
                $current[$visit['ip']] = 1;
            }

            $campaign->last_ran = $nextRun->format('Y-m-d H:i:s');
            $campaign->save();

            $campaignHistory->state_id = 5;
            $campaignHistory->save();

            //Fire Event
            CampaignProcessed::dispatch($campaign);

        }

        return null;

    }

}

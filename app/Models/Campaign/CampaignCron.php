<?php

namespace App\Models\Campaign;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignCron
{

    public function queueCampaigns() {

        // Get List of Active Campaigns
        $campaigns = Campaigns::where(['state_id' => 10]);

        //Search DynamoDB

        //Create CampaignHistory Record

        //Sent List to El Toro

    }

}

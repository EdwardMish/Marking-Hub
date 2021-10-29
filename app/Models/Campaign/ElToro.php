<?php

namespace App\Models\Campaign;

use Illuminate\Support\Facades\Storage;

class ElToro
{
    public function sendList(CampaignHistory $campaignHistory)
    {
        $targets = CampaignTargetHistory::where([
            'campaign_history_id' => $campaignHistory->id
        ])->get();

        //Stop if there aren't any new visitors
        if ($targets->count() == 0) {
            return null;
        }

        $fn = $campaignHistory->campaign_id.'-'.$campaignHistory->id.'.csv';
        $ips[] ='visitor_ip';

        foreach ($targets as $target) {
            $ips[] = $target->browser_ip;
        }
        Storage::disk('eltoro')->put($fn, implode(PHP_EOL,$ips));

    }

}

<?php

namespace App\Models\Campaign;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignTargetHistory extends Model
{
    use HasFactory;

    protected $table = 'campaign_target_history';

    protected $fillable = [
        'id',
        'browser_ip',
        'browser_user_id',
        'campaign_id',
        'campaign_history_id',
        'discount_code',
    ];

    public function getExemptUsers($campaignId) {
        $exempt = [];
        $historyFrom = (new \DateTime())->sub(new \DateInterval('P30D'));
        $mailers = $this->where('campaign_id', $campaignId)->where('created_at', '>', $historyFrom->format('Y-m-d H:i:s'))->get();
        foreach ($mailers as $mail) {
            $exempt[$mail->browser_ip] = 1;
        }

        return $exempt;
    }


}

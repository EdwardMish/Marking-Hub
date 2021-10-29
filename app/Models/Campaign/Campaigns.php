<?php

namespace App\Models\Campaign;

use App\Models\User\SocialProviders;
use App\Models\User\User;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Campaigns extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'audience_size_id',
        'discount_amount',
        'discount_prefix',
        'discount_price_rule_id',
        'discount_type',
        'last_ran',
        'project_id',
        'state_id',
        'thumbnail_url',
        'total_recipients',
        'total_cost',
        'total_revenue',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function history()
    {
        return $this->hasMany(CampaignHistory::class);
    }


    public function getAllCampaignsReadable($userId)
    {

        $campaignStates = new CampaignsState();
        $campaignAudienceSizes = new CampaignAudienceSizes();

        $campaigns = DB::table($this->getTable())
            ->join($campaignStates->getTable(), $this->table.'.state_id', '=',
                $campaignStates->getTable().'.id')
            ->join($campaignAudienceSizes->getTable(), $this->table.'.audience_size_id', '=',
                $campaignAudienceSizes->getTable().'.id')
            ->select(
                $this->getTable().'.*',
                $campaignStates->getTable().'.name as stateName',
                $campaignAudienceSizes->getTable().'.name as audienceSize'
            )
            ->where('user_id', $userId)
            ->whereNull($this->getTable().'.deleted_at')
            ->get();

        return $campaigns;
    }

    public function refreshThumbnail($projectId)
    {
        $project = $this->where(['project_id' => $projectId])->first();
    }
}

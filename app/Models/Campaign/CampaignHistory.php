<?php

namespace App\Models\Campaign;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignHistory extends Model
{
    use HasFactory;

    protected $table = 'campaign_history';

    protected $fillable = [
        'campaign_id',
        'state_id',
        'count_unique_ip',
        'count_mailers_sent',
        'cost_of_send',
        'revenue_from_mailers'
    ];



}

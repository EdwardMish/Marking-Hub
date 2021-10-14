<?php

namespace App\Models\Campaign;

use App\Models\User\SocialProviders;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CampaignsState extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'description'
    ];
}

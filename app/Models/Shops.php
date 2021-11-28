<?php

namespace App\Models;

use App\Models\Campaign\Campaigns;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Shops extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function campaign()
    {
        return $this->hasOne(Campaigns::class, 'shop_id');
    }

    public function shopsWithoutCampaigns($userId)
    {
        $campaigns = new Campaigns();
        $res = DB::table($this->getTable())
            ->select('shop_name', 'shop_id', $this->getTable().'.id')
            ->leftJoin( $campaigns->getTable(), function ($join) use ($campaigns) {
                $join->on($campaigns->getTable(). '.shop_id', '=', $this->getTable() . '.id')
                    ->whereRaw($campaigns->getTable().'.deleted_at IS NULL');
            })
            ->whereNull($campaigns->getTable().'.shop_id')
        ->get();

        return $res;


    }
}

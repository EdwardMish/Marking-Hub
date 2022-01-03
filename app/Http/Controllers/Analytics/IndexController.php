<?php

namespace App\Http\Controllers\Analytics;

use Illuminate\Routing\Controller;
// use App\Http\Controllers\Controller;
use App\Models\Analytics\Dynamo;
use App\Models\Shop;
use App\Models\Visitor;
use App\Models\VisitorIp;
use App\Models\User\SocialProviders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Frontend\LogVisitRequest;

class IndexController extends Controller
{
    public function logVisit(LogVisitRequest $request) {

        $input = $request->all();

        if($shop = Shop::where('shop_name' , $input['shopName'] )->first()){
            
            $date = \DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', $input['timestamp']);
            
            $timestamp = $date->format('Y-m-d');

            $visitor = Visitor::updateOrCreate([
                'shop_id' => $shop->id,
                'timestamp' => $timestamp,
                'type' => $input['type'],
            ],[
                'path' => $input['path'],
                'variant_id' => $input['variantId'],
                'session' => $input['sessionId'],
            ]);

            VisitorIp::create([
                'visitor_id'    =>  $visitor->id,
                'browser_ip'    =>  $input['ip'],
                'session'       =>  $input['sessionId'],
                'variant_id'    =>  $input['variantId'],
                'path'          =>  $input['path'],
            ]);

            $visitor->update(['counter' => $visitor->counter+1,]);

        }

        return response()->json([
            'Status' => 'SUCCESS'
        ]);

    }
}

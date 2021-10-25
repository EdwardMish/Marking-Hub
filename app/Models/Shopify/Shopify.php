<?php

namespace App\Models\Shopify;

use App\Models\User\SocialProviders;
use GuzzleHttp\Client;

class Shopify
{

    public function addTrackingPixel($accessToken, $storeName)
    {
        $client = new Client();
        $apiV = config('services.shopify.api_version');
        $res = $client->request('POST', 'https://'.$storeName.'/admin/api/'.$apiV.'/script_tags.json', [
            'headers' => ['X-Shopify-Access-Token' => $accessToken],
            'json' => [
                'script_tag' => [
                    'src' => config('services.shopify.script_tag'),
                    'event' => 'onload'
                ]
            ]
        ]);

        return $res;
    }

    public function getOrders(SocialProviders $social, $sinceDateTime)
    {
        $client = new Client();
        $apiV = config('services.shopify.api_version');
        $res = json_decode($client->request('GET',
            'https://'.$social->nickname.'/admin/api/'.$apiV.'/orders.json?updated_at_min='.$sinceDateTime, [
                'headers' => ['X-Shopify-Access-Token' => $social->access_token],
            ])->getBody());

        return $res->orders;
    }

    public function getAbandonCart(SocialProviders $social, $sinceDateTime)
    {
        $client = new Client();
        $apiV = config('services.shopify.api_version');
        $res = json_decode($client->request('GET',
            'https://'.$social->nickname.'/admin/api/'.$apiV.'/checkouts.json?created_at_min='.$sinceDateTime, [
                'headers' => ['X-Shopify-Access-Token' => $social->access_token],
            ])->getBody());

        return $res->checkouts;
    }

    public function submitPriceRule(SocialProviders $social, $deal)
    {
        $client = new Client();
        $apiV = config('services.shopify.api_version');
        $discountType = '';
        $title = $deal['discount_prefix'];

        //Get rid of the $/%
        // They want a BigDecimal and it needs to be negative
        $discountAmount = -1 * floatval(preg_replace("/[^0-9.]/", "", $deal['discount_amount']));

        if ($deal['discount_type'] == 1) {
            $discountType = 'percentage';
            $title = strtoupper($title.$discountAmount.'PERCENTOFF');
        } elseif ($deal['discount_type'] == 2) {
            $discountType = 'fixed_amount';
            $title = strtoupper($title.$discountAmount.'OFF');
        }

        $startsAt = (new \DateTime())->format(\DateTime::ATOM);



        $res = $client->request('POST', 'https://'.$social->nickname.'/admin/api/'.$apiV.'/price_rules.json', [
            'headers' => ['X-Shopify-Access-Token' => $social->access_token],
            'json' => [
                "price_rule" => [
                    "title" => "'.$title.'",
                    "target_type" => "line_item",
                    "target_selection" => "all",
                    "allocation_method" => "across",
                    "value_type" => $discountType,
                    "value" => $discountAmount,
                    "customer_selection" => "all",
                    "starts_at" => $startsAt
                ]
            ]
        ]);

        return $res;
    }
}

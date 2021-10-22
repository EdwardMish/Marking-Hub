<?php

namespace App\Models;

use App\Models\User\SocialProviders;
use GuzzleHttp\Client;

class Shopify
{

    public function addTrackingPixel($accessToken, $storeName)
    {

        $client = new Client();
        $res = $client->request('POST', 'https://'.$storeName.'/admin/api/2021-10/script_tags.json', [
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

    public function getOrders(SocialProviders $social, $sinceDateTime) {
        $client = new Client();
        $res = json_decode($client->request('GET', 'https://'.$social->nickname.'/admin/api/2021-10/orders.json?updated_at_min='. $sinceDateTime, [
            'headers' => ['X-Shopify-Access-Token' => $social->access_token],
        ])->getBody());

        return $res->orders;
    }

    public function getAbandonCart(SocialProviders $social, $sinceDateTime) {
        $client = new Client();
        $res = json_decode($client->request('GET', 'https://'.$social->nickname.'/admin/api/2021-10/checkouts.json?created_at_min='. $sinceDateTime, [
            'headers' => ['X-Shopify-Access-Token' => $social->access_token],
        ])->getBody());

        return $res->checkouts;
    }
}

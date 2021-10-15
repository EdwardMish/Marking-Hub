<?php

namespace App\Models;

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
                    'src' => config('services.design_huddle.api_url'),
                    'event' => 'onload'
                ]
            ]
        ]);

        return $res;

    }
}

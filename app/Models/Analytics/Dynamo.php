<?php

namespace App\Models\Analytics;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;


class Dynamo extends Model
{
    use HasFactory;

    public function logVisit($data) {

        $date = \DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', $data['timestamp']);
        $epochTime = $date->format('U');
        $ttlValue = Config::get('aws.dynamo.visits.ttl');
        $expiresAt = $date->add(new \DateInterval('PT'.$ttlValue.'S'));
        $expiresAtEpoch = $expiresAt->format('U');
        //Inserting value with tableName: "Logs" and columnName: "userId"
        $client = \AWS::createClient('DynamoDb');
        $result = $client->putItem( [
            'TableName'     => Config::get('aws.dynamo.visits.name'),
            'Item' => [
                'storename' => ['S' => $data['shopName'].'ZZZ'],
                'created_at' => ['N' => $epochTime],
                'expires_at' => ['N' => $expiresAtEpoch],
                'path' => ['S' => $data['path']],
                'variantId' =>['S' => (empty($data['variantId']) ? '' : $date['variantId'])],
                'sessionId' => ['S' => $data['sessionId']],
                'ip' => ['S' => $data['ip']],
                'type' => ['S' => $data['type']]
            ]
        ]);

        return $result;
    }
}

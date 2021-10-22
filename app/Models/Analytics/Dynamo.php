<?php

namespace App\Models\Analytics;

use App\Models\User\User;
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

        //@ToDo: enable to determine value for 'audience'

        $result = $client->putItem( [
            'TableName'     => Config::get('aws.dynamo.visits.name'),
            'Item' => [
                'user_id' => ['N' => $data['userId']],
                'created_at' => ['N' => $epochTime],
                'expires_at' => ['N' => $expiresAtEpoch],
                'path' => ['S' => $data['path']],
                'variant_id' =>['S' => (empty($data['variantId']) ? '' : $date['variantId'])],
                'session_id' => ['S' => $data['sessionId']],
                'ip' => ['S' => $data['ip']],
                'type' => ['S' => $data['type']]
            ]
        ]);

        return $result;
    }

    public function getVisitByShop(int $userId, $audience, int $createdAt)
    {
        $client = \AWS::createClient('DynamoDb');

        $response = $client->query([
            'TableName' =>  Config::get('aws.dynamo.visits.name'),
            'Key' => [
                'user_id'  => array('N' => strval($userId)),
            ],
            'ExpressionAttributeValues'
        ]);

        echo $response;

    }
}

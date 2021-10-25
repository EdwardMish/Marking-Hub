<?php

namespace App\Models\Analytics;

use App\Models\User\User;
use Aws\DynamoDb\Marshaler;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;


class Dynamo extends Model
{
    use HasFactory;

    public function logVisit($data)
    {

        $date = \DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', $data['timestamp']);
        $epochTime = $date->format('U');
        $ttlValue = Config::get('aws.dynamo.visits.ttl');
        $expiresAt = $date->add(new \DateInterval('PT'.$ttlValue.'S'));
        $expiresAtEpoch = $expiresAt->format('U');

        $client = \AWS::createClient('DynamoDb');

        //@ToDo: enable to determine value for 'audience'
        $audienceSizeId = 30;

        $result = $client->putItem([
            'TableName' => Config::get('aws.dynamo.visits.name'),
            'Item' => [
                'user_id' => ['N' => $data['userId']],
                'created_at' => ['N' => $epochTime],
                'expires_at' => ['N' => $expiresAtEpoch],
                'audience_size_id' => ['N' => $audienceSizeId],
                'path' => ['S' => $data['path']],
                'variant_id' => ['S' => (empty($data['variantId']) ? '' : $date['variantId'])],
                'session_id' => ['S' => $data['sessionId']],
                'browser_ip' => ['S' => $data['ip']],
                'type' => ['S' => $data['type']]
            ]
        ]);

        return $result;
    }

    public function getVisitByShop(int $userId, int $createdAt)
    {
        $client = \AWS::createClient('DynamoDb');
        $marshaler = new Marshaler();
        $visitor = [];

        $eav = $marshaler->marshalJson('
        {
            ":userId":'.$userId.',
            ":createdAt":'.$createdAt.'
        }');

        $tableName = Config::get('aws.dynamo.visits.name');

        $params = [
            'TableName' => $tableName,
            'KeyConditionExpression' => 'user_id = :userId and created_at >= :createdAt',
            'ExpressionAttributeValues'=> $eav
        ];

        $response = $client->query($params);

        foreach ($response['Items'] as $v) {
            $visitor[] = [
                'ip' => !empty($v['ip']) ? $marshaler->unmarshalValue($v['ip']) : null,
                'audience_id' => !empty($v['audience_id']) ? $marshaler->unmarshalValue($v['audience_id']) : null
            ];
        }

        return $visitor;

    }
}

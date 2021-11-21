<?php

namespace App\Models\Campaign;

use App\Models\DesignHuddle\PostcardExportQueue;
use App\Models\User\SocialProviders;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class DesignHuddle extends Model
{
    public function firstOrCreate(SocialProviders $socialUser)
    {
        $res = SocialProviders::where([
            'provider_id' => 2, 'provider_user_id' => $socialUser->provider_user_id
        ])->first();
        if (!$res) {
            $res = $this->createUser($socialUser);
        } elseif ((new \DateTime()) > (new \DateTime($res->token_expiration))) {
            //Refresh Token
            $response = $this->getRefreshToken($socialUser->provider_user_id);
            $res = $this->updateUser($res, $response);
        }

        return $res;

    }

    public function createUser(SocialProviders $socialUser)
    {
        $userName = $socialUser->provider_user_id;

        $resBody = $this->getRefreshToken($userName);

        $res = SocialProviders::create([
                'provider_id' => 2,
                'provider_user_id' => $userName,
                'user_id' => $socialUser->user_id,
                'access_token' => $resBody->access_token,
                'refresh_token' => $resBody->refresh_token,
                'token_expiration' => $resBody->token_expiration,
                'nickname' => $socialUser->nickname
            ]
        );

        return $res;

    }

    public function updateUser(SocialProviders $socialUser, $updates)
    {

        foreach ($updates as $k => $v) {
            if ($socialUser->isFillable($k)) {
                $socialUser->$k = $v;
            }
        }

        $socialUser->save();
        return $socialUser;
    }

    public function getThumbnail($accessToken, $projectId)
    {
        $client = new Client();
        $url = config('services.design_huddle.api_url').'api/projects/'.$projectId;
        $res = $client->request('GET', $url, [
            'headers' => ['Authorization' => 'Bearer '.$accessToken]
        ]);

        $resBody = json_decode($res->getBody()->getContents());
        $thumbnailUrl = $resBody->data->thumbnail_url;
        $file = Storage::putFileAs('campaigns/thumbnails', $thumbnailUrl, $projectId.'.jpg');
        $hostname = config('filesystems.disks.s3.url');
        $url = $hostname.$file;
        return $url;
    }

    public function convertExpiration($epoch)
    {
        $dt = (new \DateTime())->add(new \DateInterval('PT'.$epoch.'S'));
        return $dt->format('Y-m-d H:i:s');
    }

    public function getRefreshToken($userName)
    {
        // I didn't see an endpoint to refresh a token so lets just get a new one
        $client = new Client();
        $res = $client->request('POST', config('services.design_huddle.api_url').'oauth/token', [
            'form_params' => [
                'client_id' => config('services.design_huddle.client_id'),
                'client_secret' => config('services.design_huddle.client_secret'),
                'grant_type' => 'password',
                'username' => $userName
            ]
        ]);

        $resBody = json_decode($res->getBody()->getContents());
        $resBody->token_expiration = $this->convertExpiration($resBody->expires_in);

        return $resBody;
    }

    public function exportDesignQueue(Campaigns $campaign)
    {
        $socialProvider = SocialProviders::getDesignHuddleAppToken();
        $client = new Client();
        $body = ['format' => 'pdf'];
        $url = config('services.design_huddle.api_url').'partners/api/projects/'.$campaign->project_id.'/export';
        $res = $client->request('POST', $url, [
            'headers' => ['Authorization' => 'Bearer '.$socialProvider->access_token],
            'json' => $body
        ]);

        $resBody = json_decode($res->getBody()->getContents());
        $postCardQueue = PostcardExportQueue::create([
            'project_id' => $campaign->id,
            'design_huddle_project_id' => $campaign->project_id,
            'job_id' => $resBody->data->job_id
        ]);

        //I expect this to fail but why not try it!
        $this->exportDesignExecute($postCardQueue);

    }

    public function exportDesignExecute(PostcardExportQueue $export)
    {
        $socialProvider = SocialProviders::getDesignHuddleAppToken();

        $client = new Client();
        $url = config('services.design_huddle.api_url').
            'partners/api/projects/'.
            $export->design_huddle_project_id.'/export/jobs/'.
            $export->job_id;
        $res = $client->request('GET', $url, [
            'headers' => ['Authorization' => 'Bearer '.$socialProvider->access_token],
        ]);

        $resBody = json_decode($res->getBody()->getContents());

        if ($resBody->success == true && $resBody->data->completed == true) {
            //Find the Campaign
            $campaign = Campaigns::find($export->project_id);
            //Save it to S3
            $file = Storage::putFileAs('campaigns/postcards', $resBody->data->download_url,
                $export->project_id.'.pdf');
            $hostname = config('filesystems.disks.s3.url');
            //Build the entire URL
            $url = $hostname.$file;
            $campaign->postcard_design_url = $url;
            //Update the Campaign
            $campaign->save();
            //Remove the Record from the Queue
            $export->delete();
            return true;
        }
        //Looks like it wasn't ready yet do nothing
        return null;
    }

    public function refreshAppToken()
    {
        // I didn't see an endpoint to refresh a token so lets just get a new one
        $client = new Client();
        $res = $client->request('POST', config('services.design_huddle.api_url').'oauth/token', [
            'form_params' => [
                'client_id' => config('services.design_huddle.client_id'),
                'client_secret' => config('services.design_huddle.client_secret'),
                'grant_type' => 'client_credentials'
            ]
        ]);

        $resBody = json_decode($res->getBody()->getContents());
        $resBody->token_expiration = $this->convertExpiration($resBody->expires_in);
        $socialProvider = SocialProviders::firstOrCreate(['provider_user_id' => 0, 'provider_id' => 2],
            [
                'user_id' => 0,
                'access_token' => $resBody->access_token,
                'token_expiration' => $resBody->token_expiration,
            ]);

        return $socialProvider;
    }

    public function processPostcardQueue()
    {
        $res = PostcardExportQueue::all();
        foreach($res as $postcard) {
            $this->exportDesignExecute($postcard);
        }
    }

}

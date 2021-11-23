<?php

namespace App\Http\Controllers\Auth;

use App\Events\ShopConnected;
use App\Http\Controllers\Controller;
use App\Models\Shopify\Orders;
use App\Models\Shopify\Shopify;
use App\Models\Shops;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User\User;
use App\Models\User\SocialProviders;


class ShopifyController extends Controller
{
    public function callback(Request $request)
    {
        $shopifyUser = Socialite::driver('shopify')->stateless()->user();
        $users = User::firstOrCreate(
            ['email' => $shopifyUser->getEmail()],
            [
                'name' => $shopifyUser->getName(),
                'password' => User::makePassword()
            ]
        );
        $socialUser = SocialProviders::updateOrCreate(
            [
                'provider_id' => 1,
                'provider_user_id' => $shopifyUser->getId()
            ],
            [
                'user_id' => $users->id,
                'avatar' => $shopifyUser->getAvatar(),
                'nickname' => $shopifyUser->getNickname(),
                'access_token' => $shopifyUser->token,
                'refresh_token' => $shopifyUser->refreshToken,
                'token_expiration' => $shopifyUser->expiresIn
            ]
        );

        if ($socialUser->wasRecentlyCreated) {
            $shop = Shops::create([
                'user_id' => $users->id,
                'shop_name' => $shopifyUser->getNickname(),
            ]);

            (new Shopify())->addTrackingPixel($shopifyUser->token, $shopifyUser->getNickname());

            ShopConnected::dispatch($shop, $socialUser);

        }

        Auth::login($users, true);

        $user = Auth::user();

        return redirect()->intended(route('gettingStarted'));

    }

    public function retrieveOrder() {
        $social = SocialProviders::where(['provider_id' => 1, 'provider_user_id' => 55088120039])->first();
        $shop = Shops::find(2);
        (new Orders())->upsertOrder($social, $shop);
    }
}

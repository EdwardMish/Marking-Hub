<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $socialUser = SocialProviders::firstOrCreate(
            [
                'provider_id' => 1,
                'provider_user_id' => $shopifyUser->getId()
            ],
            [
                'user_id' => $users->id,
                'avatar' => $shopifyUser->getAvatar(),
                'nickname' => $shopifyUser->getNickname(),
                'token' => $shopifyUser->token,
                'refresh_token' => $shopifyUser->refreshToken,
                'token_expiration' => $shopifyUser->expiresIn
            ]
        );

        Auth::login($users, true);

        $user = Auth::user();

        return redirect()->intended('dashboard');

    }
}

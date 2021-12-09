<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ShopController extends Controller
{
    protected $userId;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            return $next($request);
        });
    }

    public function startSubscription(Request $request) {
        $rules = [
            'number' => 'required|int',
            'expiration' => ['required', 'regex:/^([0-9][0-9])\/([0-9][0-9])$/'],
            'cvv' => 'required|int',
            'shop_id' => 'required|int',
            'full_name' => ['required', 'string'],
            'offer_code' => 'string',
            'billing_zip' => ['required', 'string'],
        ];

        $validator = Validator::make($request->all(), $rules, $messages = [
            'expiration.regex' => 'Expiration date must be 2 digit month and 2 digit year',
        ]);

        if ($validator->errors()->count() > 0) {
            return redirect()->route('viewCampaigns')->withErrors($validator);
        }
    }
}

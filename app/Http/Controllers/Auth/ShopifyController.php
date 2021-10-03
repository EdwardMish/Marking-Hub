<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShopifyController extends Controller
{
    public function install (Request $request) {
        $validated = $request->validate([
            'shop' => 'required|url',
        ]);

        $shopifyApiKey =

        return $validated;

    }
}

<?php

namespace App\Http\Controllers\Shopify;

use App\Http\Controllers\Controller;
use App\Models\Shopify\Shopify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GdprController extends Controller
{
    //

    public function customerDataRequest(Request $request)
    {
        $shopifyModel = new Shopify();
        $fromShopify = $shopifyModel->validateRequestor($request);
        if (!($fromShopify)) {
            return response()->json([
                'status' => 'error',
                'messages' => 'unauthorized'
            ], 401);
        }

        Log::channel('single')->info($request->getContent());

        return response()->json([
            'status' => 'success',
            'messages' => 'accepted'
        ]);
    }

    public function customerRedact(Request $request)
    {

    }

    public function shopRedact(Request $request)
    {

    }
}

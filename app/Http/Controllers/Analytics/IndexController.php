<?php

namespace App\Http\Controllers\Analytics;

use App\Http\Controllers\Controller;
use App\Models\Analytics\Dynamo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IndexController extends Controller
{
    public function logVisit(Request $request) {

        $rules = [
            'shopName' => 'required',
            'path' => 'required',
            'variantId' => '',
            'sessionId' => 'required',
            'timestamp' => 'required|date',
            'ip' => 'required|ip',
            'type' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $messages=$validator->messages();
            $errors=$messages->all();
            return response()->json(['Status' => 'Error', 'Message' => $errors], 400);
        }

        $validated = $validator->validated();

        $logVisit = (new Dynamo())->logVisit($validated);

        return response()->json([
            'Status' => 'SUCCESS'
        ]);

    }
}

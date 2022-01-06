<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Campaign\ManualDrawRequest;
use App\Models\Campaign\Campaigns;
use App\Models\Shopify\Orders;

class ManualCampaignController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('manual-campaigns');
    }    

    public function draw(ManualDrawRequest $request)
    {
        $operator = $this->getOperator($request->operator);
        $value = $request->value;

        $data = [];
        switch($request->audience){
            case Campaigns::Prior_Customers:
                $data = $this->priorCustomers($operator, $value);
                break;
            case Campaigns::Purchase_More_Then:
                $data = $this->purchaseMoreThen($operator, $value);
                break;
            case Campaigns::purchase_More_Then_Times:
                $data = $this->purchaseMoreThenTimes($operator, $value);
                break;
            case Campaigns::Top_Customer_By_Spend:
                $data = $this->topCustomerBySpend($operator, $value);
                break;
        }

        return response()->json($data);
    }

    public function priorCustomers($operator, $value){
        return [40,60];
    }

    public function purchaseMoreThen($operator, $value){

        $selected = Orders::select(\DB::raw('COUNT(customer_id) as count'))
        ->leftJoin('shop_order_history_discount_codes','shop_order_history_discount_codes.order_id','=','shop_order_history.id')
        ->groupBy('customer_id')->havingRaw("SUM(`order_total`) {$operator['selectedOpr']} {$value}")->sum('count');
        $whole = Orders::select(\DB::raw('COUNT(customer_id) as count'))
        ->leftJoin('shop_order_history_discount_codes','shop_order_history_discount_codes.order_id','=','shop_order_history.id')
        ->groupBy('customer_id')->havingRaw("SUM(`order_total`) {$operator['otherOpr']} {$value}")->sum('count');

        return $this->getPersCalculated($selected, $whole);
    }

    public function purchaseMoreThenTimes($operator, $value){

        $selected = Orders::select(\DB::raw('COUNT(customer_id) as count'))
        ->leftJoin('shop_order_history_discount_codes','shop_order_history_discount_codes.order_id','=','shop_order_history.id')
        ->groupBy('customer_id')->havingRaw("COUNT(shop_order_history_discount_codes.discount_code) {$operator['selectedOpr']} {$value}")->sum('count');
        $whole = Orders::select(\DB::raw('COUNT(customer_id) as count'))
        ->leftJoin('shop_order_history_discount_codes','shop_order_history_discount_codes.order_id','=','shop_order_history.id')
        ->groupBy('customer_id')->havingRaw("COUNT(shop_order_history_discount_codes.discount_code) {$operator['otherOpr']} {$value}")->sum('count');

        return $this->getPersCalculated($selected, $whole);
    }

    public function topCustomerBySpend($operator, $value){
        return [45,55];
    }


    public function getPersCalculated($selected, $whole){
        $selected = (float)$selected;
        $whole = (float)$whole;

        $total = $selected + $whole;
        $selectedPer = $selected / $total * 100;
        $wholePer = $whole / $total * 100;

        return [ (float) number_format($selectedPer,2,'.',''), (float) number_format($wholePer,2,'.','')];

    }

    public function getOperator($operator){
        switch($operator){
            case 'less than':
                $selectedOpr = '<';
                $otherOpr = '>=';
                break;
            case 'greator to':
                $selectedOpr = '>';
                $otherOpr = '<=';
                break;
            case 'equals':
                $selectedOpr = '=';
                $otherOpr = '!=';
        }
        return [
            'selectedOpr' => $selectedOpr,
            'otherOpr' => $otherOpr,
        ];
    }

}

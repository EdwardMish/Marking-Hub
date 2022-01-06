<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Shop;
use App\Models\Shopify\Shopify;
use App\Models\User\SocialProviders;
use App\Models\Mongo\Orders;

class FetchShopOrdersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $shopifyUserId;

    private $shopId;

    private $token;

    private $limit = 50;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($shopId, $token = '')
    {
        $this->shopId         = $shopId;
        $this->token          = $token;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $shopify = new Shopify();
            $shop = Shop::find($this->shopId);
            $shopifyUser = SocialProviders::where(['provider_id' => 1, 'nickname' => $shop->shop_name])->first();

            $ordersData = $shopify->getAllOrders($shopifyUser, $this->token, $this->limit);
            $orders = $ordersData['data'];
            $next_token = $ordersData['next'];
            $count = count($orders);
            \Log::info('shop orders data',[$shop->id, $count]);
            foreach ($orders as $order) {
                //Insert into Order History
                $orderRecord = Orders::updateOrCreate([
                    'id'        => $order->id,
                    'shop_id'   => $shop->id,
                ],(array) $order);
            }

            if($next_token != ''){
                dispatch(new FetchShopOrdersJob($this->shopId, $next_token));
            }
        } catch (\Exception $e) {
            \Log::info('Fetch orders shops exception', [$e->getMessage()]);
        }
    }
}

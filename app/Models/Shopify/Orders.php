<?php

namespace App\Models\Shopify;

use App\Models\Shops;
use App\Models\User\SocialProviders;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $table = 'client_order_history';

    protected $fillable = [
        'id',
        'user_id',
        'order_total',
        'browser_ip',
        'status',
    ];

    public function codes()
    {
        return $this->hasMany(OrdersDiscountCodes::class);
    }

    public function upsertOrder(SocialProviders $shopifyUser, Shops $shop, $limit = 50)
    {
        $updated = $shop->order_history_last_updated ?? '1970-01-01 00:00:00';
        $ordersSince = \DateTime::createFromFormat('Y-m-d H:i:s', $updated)->format( \DateTime::ISO8601);
        $shopify = new Shopify();
        $count = $limit;
        while ($count == $limit) {
            $orders = $shopify->getOrders($shopifyUser, $ordersSince, $limit);
            $count = count($orders);
            foreach ($orders as $order) {
                //Insert into Order History
                Orders::updateOrCreate([
                    'id' => $order->id,
                    'user_id' => $shopifyUser->user_id,
                    'order_total' => $order->total_price,
                    'browser_ip' => $order->browser_ip
                ]);
                OrdersDiscountCodes::where(['order_id' => $order->id])->delete();
                foreach($order->discount_codes as $codes) {
                    OrdersDiscountCodes::create([
                        'order_id' => $order->id,
                        'discount_code' => $codes->code
                    ]);

                    //Update Campaign Stats & Campaign History Data
                    // @ToDo: Serch for Discount Code and Update

                }
                //Get the last date for the next potential run
                $ordersSince = $order->updated_at;
            }
        }
        $lastUpdate = \DateTime::createFromFormat(\DateTime::ISO8601, $ordersSince)->format('Y-m-d H:i:s');
        $shop->order_history_last_updated = $lastUpdate;
        $shop->save();
    }

    public function getExemptUsers($userId) {
        $exempt = [];
        $ordersFrom = (new \DateTime())->sub(new \DateInterval('P30D'));
        $orders = $this->where('user_id', $userId)->where('created_at' > $ordersFrom->format('Y-m-d H:i:s'));
        foreach ($orders as $order) {
            $exempt[$order->browser_ip] = 1;
        }

        return $exempt;
    }
}

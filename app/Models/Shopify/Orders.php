<?php

namespace App\Models\Shopify;

use App\Models\Shopify;
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

    public function upsertOrder(SocialProviders $shopifyUser, $ordersSince)
    {
        $shopify = new Shopify();
        $orders = $shopify->getOrders($shopifyUser, $ordersSince);
        foreach ($orders as $order) {
            //Insert into Order History
            Shopify\Orders::updateOrCreate([
                'id' => $order['id'],
                'user_id' => $shopifyUser->user_id,
                'order_total' => $order['total_price'],
                'browser_ip' => $order['browser_ip']
            ]);
            Shopify\OrdersDiscountCodes::where(['order_id' => $order['id']])->delete();
            foreach($order['discount_codes'] as $codes) {
                Shopify\OrdersDiscountCodes::create([
                    'order_id' => $order['id'],
                    'discount_code' => $codes['code']
                ]);

                //Update Campaign Stats & Campaign History Data
                //@ToDo: Move this to an event
                //@ToDo: update stats :D
            }

        }
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

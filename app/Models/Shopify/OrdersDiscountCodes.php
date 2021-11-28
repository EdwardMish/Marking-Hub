<?php

namespace App\Models\Shopify;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersDiscountCodes extends Model
{
    use HasFactory;

    protected $table = 'shop_order_history_discount_codes';

    protected $guarded = ['id'];

    public function orders()
    {
        return $this->belongsTo(Orders::class);
    }
}

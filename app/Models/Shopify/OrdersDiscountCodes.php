<?php

namespace App\Models\Shopify;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersDiscountCodes extends Model
{
    use HasFactory;

    protected $table = 'client_order_history_discount_codes';

    protected $fillable = [
        'order_id',
        'discount_code',
    ];

    public function orders()
    {
        return $this->belongsTo(Orders::class);
    }
}

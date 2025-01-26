<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreCouponUsages extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'store_coupon_usages';

    public function store_coupon()
    {
        return $this->belongsTo(StoreCoupons::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customers::class);
    }

    public function order()
    {
        return $this->belongsTo(Orders::class);
    }
}

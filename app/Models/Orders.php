<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'orders';

    public function customer()
    {
        return $this->belongsTo(Customers::class);
    }

    public function store()
    {
        return $this->belongsTo(Stores::class);
    }

    public function store_table()
    {
        return $this->belongsTo(StoreTables::class);
    }

    public function order_delivery()
    {
        return $this->hasOne(OrderDeliveries::class);
    }

    public function order_products()
    {
        return $this->hasMany(OrderProducts::class);
    }

    public function store_coupon_usage()
    {
        return $this->hasOne(StoreCouponUsages::class);
    }

    public function financial_transaction()
    {
        return $this->belongsTo(FinancialTransactions::class);
    }
}

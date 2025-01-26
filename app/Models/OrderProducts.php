<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProducts extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'order_products';
    protected $guarded = [];


    public function order()
    {
        return $this->belongsTo(Orders::class);
    }

    public function product()
    {
        return $this->belongsTo(Products::class);
    }

    public function order_product_options()
    {
        return $this->hasMany(OrderProductOptions::class);
    }
}

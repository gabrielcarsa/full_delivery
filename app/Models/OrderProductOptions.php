<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProductOptions extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'order_product_options';
    protected $guarded = [];

    public function order_product()
    {
        return $this->belongsTo(OrderProduct::class);
    }

    public function product_option()
    {
        return $this->belongsTo(ProductOptions::class);
    }

    public function order_product_option_customizations()
    {
        return $this->hasMany(OrderProductOptionCustomizations::class);
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProductOptionCustomizations extends Model
{
    use HasFactory;
    protected $table = 'order_product_option_customizations';
    protected $guarded = [];
    public $timestamps = false;

    //RELACIONAMENTOS

    public function product_option_customization()
    {
        return $this->belongsTo(ProductOptionCustomizations::class);
    }

    public function order_product_options()
    {
        return $this->belongsTo(OrderProductOptions::class);
    }
}

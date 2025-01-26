<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOptionCustomizations extends Model
{
    use HasFactory;
    protected $table = 'product_option_customizations';
    protected $guarded = [];

    //RELACIONAMENTOS

    public function product_options()
    {
        return $this->belongsTo(ProductOptions::class);
    }

    public function order_product_option_customizations()
    {
        return $this->hasMany(OrderProductOptionCustomizations::class);
    }
}

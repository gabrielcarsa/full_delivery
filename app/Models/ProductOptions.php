<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOptions extends Model
{
    use HasFactory;
    protected $table = 'product_options';
    protected $guarded = [];

    //RELACIONAMENTOS

    public function product_option_category()
    {
        return $this->belongsTo(ProductOptionCategories::class);
    }

    public function created_by_user()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function updated_by_user()
    {
        return $this->belongsTo(User::class, 'updated_by_user_id');
    }

    public function product_option_customizations()
    {
        return $this->hasMany(ProductOptionCustomizations::class);
    }

    public function order_product_options()
    {
        return $this->hasMany(OrderProductOptions::class);
    }

}

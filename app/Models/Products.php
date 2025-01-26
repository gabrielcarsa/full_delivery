<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $guarded = [];

    //RELACIONAMENTOS

    public function product_category()
    {
        return $this->belongsTo(ProductCategories::class);
    }

    public function created_by_user()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function updated_by_user()
    {
        return $this->belongsTo(User::class, 'updated_by_user_id');
    }

    public function product_option_categories()
    {
        return $this->hasMany(ProductOptionCategories::class);
    }
  
    public function order_products()
    {
        return $this->hasMany(OrderProducts::class);
    }
}

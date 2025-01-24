<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'product';
    protected $guarded = [];

    //RELACIONAMENTOS

    public function product_category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function created_by_user()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

   public function updated_by_user()
    {
        return $this->belongsTo(User::class, 'updated_by_user_id');
    }

    public function product_options_category()
    {
        return $this->hasMany(ProductOptionsCategory::class);
    }
  
    public function itensPedido()
    {
        return $this->hasMany(ItemPedido::class, 'produto_id');
    }
}

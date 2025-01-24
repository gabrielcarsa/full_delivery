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

    public function product_options_category()
    {
        return $this->belongsTo(ProductOptions::class);
    }

    public function created_by_user()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function updated_by_user()
    {
        return $this->belongsTo(User::class, 'updated_by_user_id');
    }

    public function product_options_customizations()
    {
        return $this->hasMany(ProductOptionsCustomizations::class);
    }

    public function opcional_item()
    {
        return $this->hasMany(OpcionalItem::class, 'opcional_produto_id');
    }

}

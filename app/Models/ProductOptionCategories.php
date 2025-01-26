<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOptionCategories extends Model
{
    use HasFactory;
    protected $table = 'product_option_categories';
    protected $guarded = [];


    public function product()
    {
        return $this->belongsTo(Products::class);
    }
    
    public function created_by_user()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function updated_by_user()
    {
        return $this->belongsTo(User::class, 'updated_by_user_id');
    }

    public function product_options()
    {
        return $this->hasMany(ProductOptions::class);
    }
   
}

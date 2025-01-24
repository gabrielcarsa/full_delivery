<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOptionsCategory extends Model
{
    use HasFactory;
    protected $table = 'product_options_category';
    protected $guarded = [];


    public function product()
    {
        return $this->belongsTo(Produto::class);
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

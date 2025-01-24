<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;
    protected $table = 'product_category';
    protected $guarded = [];

    //RELACIONAMENTOS
    
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function created_by_user()
    {
       return $this->belongsTo(User::class, 'created_by_user_id');
    }
 
    public function updated_by_user()
    {
       return $this->belongsTo(User::class, 'updated_by_user_id');
    }
    
    public function product()
    {
        return $this->hasMany(Product::class);
    }
}

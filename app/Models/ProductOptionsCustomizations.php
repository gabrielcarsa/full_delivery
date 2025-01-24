<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOptionsCustomizations extends Model
{
    use HasFactory;
    protected $table = 'product_options_customizations';
    protected $guarded = [];

    //RELACIONAMENTOS

    public function product_options()
    {
        return $this->belongsTo(ProductOptions::class);
    }

    public function customizacao_opcional_item()
    {
        return $this->hasMany(CustomizacaoOpcionalItem::class);
    }
}

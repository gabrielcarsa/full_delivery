<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomizacaoOpcional extends Model
{
    use HasFactory;
    protected $table = 'customizacao_opcional';
    protected $guarded = [];

    //RELACIONAMENTOS

    public function opcional_produto()
    {
        return $this->belongsTo(OpcionalProduto::class);
    }

    public function customizacao_opcional_item()
    {
        return $this->hasMany(CustomizacaoOpcionalItem::class);
    }
}

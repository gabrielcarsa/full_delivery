<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPedido extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'item_pedido';
    protected $guarded = [];


    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }

    // Relação um para muitos com Opcionais de Item
    public function opcional_item()
    {
        return $this->hasMany(OpcionalItem::class);
    }
}

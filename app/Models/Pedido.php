<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'pedido';

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function restaurante()
    {
        return $this->belongsTo(Restaurante::class);
    }

    public function forma_pagamento()
    {
        return $this->belongsTo(FormaPagamentoEntrega::class);
    }

    public function meio_pagamento()
    {
        return $this->belongsTo(MeioPagamentoEntrega::class);
    }

    public function entrega()
    {
        return $this->hasOne(Entrega::class);
    }

    public function item_pedido()
    {
        return $this->hasMany(ItemPedido::class); // UM PARA MUITOS (Um pedido pode ter muitos itens)
    }

    /*public function produto()
    {
        return $this->hasManyThrough(Produto::class, ItemPedido::class, 'pedido_id', 'id', 'id', 'produto_id'); //MUITOS PARA MUITOS (um produto pode ter muitos pedidos e um pedido por ter muitos produtos)
    }*/
}

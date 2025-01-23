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

    public function loja()
    {
        return $this->belongsTo(Loja::class);
    }

    public function forma_pagamento()
    {
        return $this->belongsTo(FormaPagamento::class);
    }

    public function entrega()
    {
        return $this->hasOne(Entrega::class);
    }

    public function item_pedido()
    {
        return $this->hasMany(ItemPedido::class); // UM PARA MUITOS (Um pedido pode ter muitos itens)
    }

    public function uso_cupom()
    {
        return $this->hasOne(UsoCupom::class);
    }

    public function mesa()
    {
        return $this->belongsTo(Mesa::class);
    }

    public function lancamento()
    {
        return $this->belongsTo(Lancamento::class);
    }
}

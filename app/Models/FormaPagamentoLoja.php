<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormaPagamentoLoja extends Model
{
    use HasFactory;
    protected $table = 'forma_pagamento_loja';

    public function pedido()
    {
        return $this->hasMany(Pedido::class);
    }
}

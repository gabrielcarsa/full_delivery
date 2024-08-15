<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormaPagamentoFoomy extends Model
{
    use HasFactory;
    protected $table = 'forma_pagamento_foomy';


    public function pedido()
    {
        return $this->hasMany(Pedido::class);
    }
}

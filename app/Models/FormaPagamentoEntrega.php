<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormaPagamentoEntrega extends Model
{
    use HasFactory;
    protected $table = 'forma_pagamento_entrega';


    public function forma_pagamento()
    {
        return $this->hasMany(FormaPagamentoEntrega::class);
    }
}

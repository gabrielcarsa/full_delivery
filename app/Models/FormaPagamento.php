<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormaPagamento extends Model
{
    use HasFactory;
    protected $table = 'forma_pagamento';
    public $timestamps = false;

    public function forma_pagamento_loja()
    {
        return $this->hasMany(FormaPagamentoLoja::class);
    }
}

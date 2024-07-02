<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsoCupom extends Model
{
    use HasFactory;
    protected $table = 'uso_cupom';

    public function cupom()
    {
        return $this->belongsTo(Cupom::class);
    }

    public function cliente()
    {
        return $this->belongsToMany(Cliente::class);
    }

    public function pedido()
    {
        return $this->belongsToMany(Pedido::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $table = 'cliente';

    public function pedido()
    {
        return $this->hasMany(Pedido::class);
    }

    public function uso_cupom()
    {
        return $this->belongsToMany(UsoCupom::class);
    }
}

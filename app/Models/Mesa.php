<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'mesa';

    public function loja()
    {
       return $this->belongsTo(Loja::class);
    }

    public function pedido()
    {
       return $this->hasMany(Pedido::class);
    }
}

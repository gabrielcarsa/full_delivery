<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrega extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'entrega';

    protected $fillable = [
        'pedido_id', 'cep', 'rua', 'bairro', 'cidade', 'estado', 'numero', 'complemento', 'taxa_entrega'
        // Adicione outros campos conforme necessário
    ];


    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
}

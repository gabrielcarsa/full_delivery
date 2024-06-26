<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpcionalItem extends Model
{
    use HasFactory;
    protected $table = 'opcional_item';

    // Relação muitos para um com Item de Pedido
    public function itemPedido()
    {
        return $this->belongsTo(ItemPedido::class, 'item_pedido_id');
    }

    // Relação muitos para um com Cliente que cadastrou
    public function cadastradoPor()
    {
        return $this->belongsTo(User::class, 'cadastrado_usuario_id');
    }

    // Relação muitos para um com Cliente que alterou
    public function alteradoPor()
    {
        return $this->belongsTo(User::class, 'alterado_usuario_id');
    }

    // Relação muitos para um com Opcional de Produto
    public function opcionalProduto()
    {
        return $this->belongsTo(OpcionalProduto::class, 'opcional_produto_id');
    }
}

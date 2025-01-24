<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'product';
    protected $guarded = [];

    //RELACIONAMENTOS

    public function product_category()
    {
        return $this->belongsTo(ProductCategory::class);
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

    // Relação um para muitos com Itens de Pedido
    public function itensPedido()
    {
        return $this->hasMany(ItemPedido::class, 'produto_id');
    }

    // Relação um para muitos com Opcionais de Produto
    public function categoria_opcional()
    {
        return $this->hasMany(CategoriaOpcional::class, 'produto_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpcionalProduto extends Model
{
    use HasFactory;
    protected $table = 'opcional_produto';

    //RELACIONAMENTOS

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }

    // Relação um para muitos com Opcionais de Item
    public function opcionaisItem()
    {
        return $this->hasMany(OpcionalItem::class, 'opcional_produto_id');
    }

    public function usuarioCadastrador()
    {
        return $this->belongsTo(User::class, 'cadastrado_usuario_id');
    }

    public function usuarioAlterador()
    {
        return $this->belongsTo(User::class, 'alterado_usuario_id');
    }
}

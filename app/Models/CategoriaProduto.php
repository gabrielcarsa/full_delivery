<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaProduto extends Model
{
    use HasFactory;
    protected $table = 'categoria_produto';

    //RELACIONAMENTOS
    
    public function loja()
    {
        return $this->belongsTo(Loja::class);
    }

    public function usuarioCadastrador()
    {
        return $this->belongsTo(User::class, 'cadastrado_usuario_id');
    }

    public function usuarioAlterador()
    {
        return $this->belongsTo(User::class, 'alterado_usuario_id');
    }
    
    public function produto()
    {
        return $this->hasMany(Produto::class);
    }
}

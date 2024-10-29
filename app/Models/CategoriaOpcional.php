<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaOpcional extends Model
{
    use HasFactory;
    protected $table = 'categoria_opcional';
    protected $guarded = [];


    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
    
    public function usuarioCadastrador()
    {
        return $this->belongsTo(User::class, 'cadastrado_usuario_id');
    }

    public function usuarioAlterador()
    {
        return $this->belongsTo(User::class, 'alterado_usuario_id');
    }

    // Relação um para muitos
    public function opcional_produto()
    {
        return $this->hasMany(OpcionalProduto::class);
    }
   
}
